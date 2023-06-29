<?php

declare(strict_types=1);

namespace Drupal\stage_file_proxy\Controller;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Image\ImageFactory;
use Drupal\Core\Lock\LockBackendInterface;
use Drupal\Core\StreamWrapper\StreamWrapperManagerInterface;
use Drupal\image\Controller\ImageStyleDownloadController as CoreImageStyleDownloadController;
use Drupal\image\ImageStyleInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

/**
 * Decorate core's image style controller to retry failed requests.
 */
final class ImageStyleDownloadController implements ContainerInjectionInterface {

  /**
   * The decorated used to decorate the images.
   *
   * @var \Drupal\image\Controller\ImageStyleDownloadController
   */
  private CoreImageStyleDownloadController $decorated;

  /**
   * Constructs an ImageStyleDownloadController object.
   *
   * @param \Drupal\Core\Lock\LockBackendInterface $lock
   *   The lock backend.
   * @param \Drupal\Core\Image\ImageFactory $image_factory
   *   The image factory.
   * @param \Drupal\Core\StreamWrapper\StreamWrapperManagerInterface $stream_wrapper_manager
   *   The stream wrapper manager.
   * @param \Drupal\Core\File\FileSystemInterface $file_system
   *   The system service.
   */
  public function __construct(LockBackendInterface $lock, ImageFactory $image_factory, StreamWrapperManagerInterface $stream_wrapper_manager, FileSystemInterface $file_system = NULL) {
    $this->decorated = new CoreImageStyleDownloadController($lock, $image_factory, $stream_wrapper_manager, $file_system);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('lock'),
      $container->get('image.factory'),
      $container->get('stream_wrapper_manager'),
      $container->get('file_system')
    );
  }

  /**
   * Retry generating a derivative in the case of parallel requests.
   *
   * Stage File Proxy is often used on locals that may have slower internet
   * connections compared to hosted environments. If multiple image style
   * requests need to download a large image, image module will immediately
   * return a 503 on subsequent requests while the first request is downloading
   * the source image. This can also happen in "normal" hosting environments if
   * enough parallel requests happen and a caching reverse proxy or CDN isn't in
   * place to combine multiple requests into a single Drupal request.
   *
   * To work around this, we decorate core's image controller and try to deliver
   * the image again for up to 5 seconds. While this could cause a queue of PHP
   * processes in production workloads, we assume that Stage File Proxy is used
   * in scenarios where that won't be an issue.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request object.
   * @param string $scheme
   *   The file scheme, defaults to 'private'.
   * @param \Drupal\image\ImageStyleInterface $image_style
   *   The image style to deliver.
   *
   * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Symfony\Component\HttpFoundation\Response
   *   The transferred file as response or some error response.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
   *   Thrown when the file request is invalid.
   * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
   *   Thrown when the user does not have access to the file.
   * @throws \Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException
   *   Thrown when the file is still being generated.
   */
  public function deliver(Request $request, string $scheme, ImageStyleInterface $image_style) {
    $tries = 5;
    do {
      try {
        return $this->decorated->deliver($request, $scheme, $image_style);
      }
      catch (ServiceUnavailableHttpException $e) {
        $tries--;
        usleep(250000);
      }
    } while ($tries > 0);

    throw $e;
  }

}
