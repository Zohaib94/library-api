<?php
$newsList = [
  ['title' => 'First World War', 'date' => '1914-07-28'],
  ['title' => 'Second World War', 'date' => '1939-09-01'],
  ['title' => 'First man on the moon', 'date' => '1969-07-
 20']
];
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