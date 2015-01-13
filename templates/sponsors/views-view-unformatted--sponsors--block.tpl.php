<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php foreach ($rows as $id => $row): ?>
  <div<?php if ($classes_array[$id]) { print ' class="sponsor"';  } ?>>
  	<?php print $row; ?>
  </div>
<?php endforeach; ?>
