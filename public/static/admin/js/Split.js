/**
 * Created by DELL on 2018/4/28.
 */
$(function(){
    if( $(".bg-main").attr("id")==1){
        $(".start").attr("checked","true")
    }else{
        $("input").attr("readonly","true");
        $(".close").attr("checked","true")
    }
    //设置分成比例
    $(".bg-main").click(function(){

        if($('input:radio:checked').val()==1){

            founder=$("input[name=fc3]").attr("value");
            ini=$("input[name=fc2]").attr("value");
            parn=$("input[name=fc1]").attr("value");
            staff=$("input[name=fc]").attr("value");
            num=/^\d+(\.\d+)?$/;
            if (!num.exec(founder) || !num.exec(ini) || !num.exec(parn) || !num.exec(staff)){
                alert("分成比例必须为正数或小数！")
            }else{

            $.ajax({
                type:"post",
                dataType:"json",
                url:"?s=admin/Splitratio/bili",
                data:{
                    founder:founder,
                    ini:ini,
                    parn:parn,
                    staff:staff
                },
                success:function(){
                    window.location.reload();
                }
            })

            }
        }else{
            $.ajax({
                type:"post",
                dataType:"json",
                url:"?s=admin/Splitratio/close",
                data:{
                   id:1
                },
                success:function(){
                    window.location.reload();
                }
            })
        }
    })


});

function fun(){
    return false;
}