<?php if( ! $locked ): ?>
<a href="<?php echo $edit_url; ?>">
    <strong><?php echo $title; ?></strong>
</a>
<?php else: ?>
    <strong><?php echo $title; ?></strong>
<?php endif; ?>

<div class="row-actions">

    <?php if( ! $locked ): ?>
    <span class="edit">
        <a href="<?php echo $edit_url; ?>">Edit</a> |
    </span>
    <?php endif; ?>

    <?php if( ! $locked ): ?>
    <span class="trash">
        <a href="<?php echo $delete_url; ?>">Delete</a> |
    </span>
    <?php endif; ?>

    <span class="duplicate">
        <a href="<?php echo $duplicate_url; ?>">Duplicate</a> |
    </span>

    <?php if( ! $locked ): ?>
    <span class="bleep">
        <a href="<?php echo $preview_url; ?>">Preview Form</a> |
    </span>
    <?php endif; ?>

    <span class="subs">
        <a target="_blank" href="<?php echo $submissions_url; ?>">View Submissions</a>
    </span>

</div>
