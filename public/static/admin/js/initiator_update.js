
   $(function(){
       //编辑的确定操作
      $("input[name=dosubmit]").click(function(){
      number=$(this).attr("id");
          $.ajax({
              type:"post",
              dataType:"json",
              url:'?s=admin/Initiator/date',
              data:{
                  idd:number,
                  content:$(".dengji").val()
              },
              success:function(){
                  window.parent.location.reload();

              }

          })
      }),

          //删除用户
       $("input[name=button]").click(function(){
          parent.layer.closeAll();
       });

       //添加中的查询操作
       $(".chaxun").click(function(){
           $.ajax({
               type:"post",
               dataType:"json",
               url:'?s=admin/Initiator/Inidate',
               data:{
                   name:$(".cxtj").val()
               },
               success:function(m){
                   if(m=="false"){
                       alert("查无此人！")
                   }else{
                       $(".mxx").css("display","block");
                       $(".imgg").prop("src",m[0]["avatar"]);
                       $(".cname").html(m[0]["username"]);
                       $(".bjid").prop("name",m[0]["id"]);
                       //window.parent.location.reload();
                   }

               }

           })
       })

       //添加中的确定操作
       $("input[name=dsubmit]").click(function(){
           number= $(".bjid").attr("name");

           if(number==""){
               alert("请先进行查询操作！")
           }else{
               $.ajax({
                   type:"post",
                   dataType:"json",
                   url:'?s=admin/Initiator/date',
                   data:{
                       idd:number,
                       content:$(".dengji").val()
                   },
                   success:function(){
                       window.parent.location.reload();
                   }
               })
           }

       })

   });

