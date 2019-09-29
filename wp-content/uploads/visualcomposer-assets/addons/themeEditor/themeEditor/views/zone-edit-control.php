<?php

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}
?>

<div class="vcv-zone-overlay">
    <?php if (empty($blockId)) : ?>
        <span class="vcv-zone-button" data-vcv-action="settings">
            <i class="vcv-ui-icon vcv-ui-icon-add"></i>
            <?php echo sprintf(esc_html__('Add %s', 'vcwb'), $title); ?>
        </span>
    <?php endif; ?>
    <?php if (!empty($editLink)) : ?>
        <div class="vcv-zone-button-container">
            <span class="vcv-zone-button" data-vcv-action="settings">
                <i class="vcv-ui-icon vcv-ui-icon-copy"></i>
                <?php echo sprintf(esc_html__('Replace %s', 'vcwb'), $title); ?>
            </span>
            <a href="<?php echo $editLink; ?>" target="_blank" class="vcv-zone-button" data-vcv-link>
                <i class="vcv-ui-icon vcv-ui-icon-edit"></i>
                <?php echo sprintf(esc_html__('Edit %s', 'vcwb'), $title); ?>
            </a>
        </div>
    <?php endif; ?>
</div>