<?php
 // $newsList is from action
?>
<table>
  <tr>
    <th>Title</th>
    <th>Date</th>
  </tr>
  <?php foreach ($newsList as $item) { ?>
    <tr>
      <td><?php echo $item['title'] ?></td>
      <td><?php echo $item['date'] ?></td>
    </tr>
  <?php } ?>
</table>