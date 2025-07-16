Detail item with title <b><?php echo $item['title'] ?></b>
<br /><br />
<?php if ($item != null) { ?>
  <table border="1">
    <?php foreach ($item as $key => $value) { ?>
      <tr>
        <th><?php echo $key ?></th>
        <td><?php echo $value ?></td>
      </tr>
    <?php } ?>
  </table>
  <br />
  Url for this items is: <?php echo yii\helpers\Url::to([
    'news/item-detail-new',
    'title' => $item['title']
  ]); ?>
<?php } else { ?>
  <i>No item found</i>
<?php } ?>

