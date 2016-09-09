<?php

/**
 * @file
 * Contains \Drupal\custom_module\Controller\ModalController.
 */

namespace Drupal\custom_module\Controller;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ModalController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function page(){
    $content = array(
      'content' => array(
        '#markup' => 'My return',
      ),
    );
    $options = array( 'width' => '80%', );
    $response = new AjaxResponse();
    $html = drupal_render($content);
    $response->addCommand(new OpenModalDialogCommand('Hi', $html,$options));
    return $response;
  }
}
