<?php
/**
* @file
* Contains \Drupal\custom_module\Plugin\Block\ContactFormBlock.
*/

namespace Drupal\custom_module\Plugin\Block;
use Drupal\Core\Block\BlockBase;


/**
* Provides Custom Block.
*
* @Block(
* id = "attorney_details_contact_form_block",
* admin_label = @Translation("Contact Form"),
* category = @Translation("Form")
* )
*/
class ContactFormBlock extends BlockBase {

/**
* {@inheritdoc}
*/
public function build() {
$build = array();

$attr_id = \Drupal::request()->attributes->get('arg_0');
$attr = \Drupal\node\Entity\Node::load($attr_id);
$attr_name = $attr->field_first_name->value . ' ' . $attr->field_last_name->value;

$build['#markup'] = '' . t('Get introduced to ') . $attr_name;
$build['#weight'] = -100;
$build['form'] = \Drupal::formBuilder()->getForm('Drupal\custom_module\Form\ContactForm');

return $build;
}
}
?>
