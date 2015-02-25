<?php foreach ($rows as $id => $row): ?>
  <div<?php if ($classes_array[$id]) { print ' class="advartage"';  } ?>>
  	<?php print $row; ?>
  </div>
<?php endforeach; ?>
