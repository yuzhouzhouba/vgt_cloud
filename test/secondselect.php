<?php
$brands = array(
    '东风本田' => array('艾力绅','本田CR-V'),

);
// 输出HTML标签
echo '<select name="brands" size="1">';
echo '<option value="">请选择车系</option>';

foreach ($brands as $brand => $items) {
    echo '<optgroup label="',$brand,'">';
    foreach ($items as $item) {
        echo '<option value="',$item,'">',$item,'</option>';
    }
    echo '</optgroup>';
}
echo '</select>';
?>