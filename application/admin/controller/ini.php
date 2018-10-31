<?php
//输出的文件类型为excel
header("Content-type:application/vnd.ms-excel");
//提示下载
header("Content-Disposition:attachement;filename=Haoyunyun.xls");
//报表数据
$ReportArr = array(array(1,2,3,4,5),
    array('A','B','C','D','E'),
    array('up','down','left','right','center'),
    array('欢','迎','光','临','','的','CSDN','博客')
);
$ReportContent = '';
$num1 = count($ReportArr);
for($i=0;$i<$num1;$i++){
    $num2 = count($ReportArr[$i]);
    for($j=0;$j<$num2;$j++){
        //ecxel都是一格一格的，用\t将每一行的数据连接起来
        $ReportContent .= '"'.$ReportArr[$i][$j].'"'."\t";
    }
    //最后连接\n 表示换行
    $ReportContent .= "\n";
}
//用的utf-8 最后转换一个编码为gb
$ReportContent = mb_convert_encoding($ReportContent,"gb2312","utf-8");
//输出即提示下载
echo $ReportContent;
