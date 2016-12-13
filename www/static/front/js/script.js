$(function(){
	FontSize()
	$(window).resize(function(){
			FontSize()
		})
	function FontSize(){
		if($(window).width()<640){
			$("html").css("font-size",$(window).width()/640*20);
		}else{
			$("html").css("font-size",20);
		}
	}
})

$(function(){
	
	
	
	//购物车 加减  
    $(".add").click(function(){
        var n=$(this).parents("li").find(".input_num").val();
        var num=parseInt(n)+1;
        //if(num==0){alert("cc");}
        $(this).parents("li").find(".input_num").val(num);
    });
    $(".jian").click(function(){
        var n=$(this).parents("li").find(".input_num").val();
        var num=parseInt(n)-1;
        if(num==0){return}
        $(this).parents("li").find(".input_num").val(num);
    });
	
});



$(function(){
 var tabTitle = ".tab dt span";
 var tabContent = ".tab dd";
 $(tabTitle + ":first").addClass("hover");
 $(tabContent).not(":first").hide();
 $(tabTitle).unbind("click").bind("click", function(){
  $(this).siblings("span").removeClass("hover").end().addClass("hover");
  var index = $(tabTitle).index( $(this) );
  $(tabContent).eq(index).siblings(tabContent).hide().end().fadeIn(0);
   });
});

/**
 * 规格点击显示和隐藏                                                                                                     [description]
 */
$(function(){
	$(document).on("click",'.goodsIsEnableClick',function(){
		$(".money").show();
    var goods_id = $(this).data("goodsid");
    $(".price-hidden").find("input[name='goods_id']").val(goods_id);
	});
	$(document).on("click",'.closeMoney',function(){
		$(".money").hide();
	});
  $(document).on("click",'.transPrice',function(){
    $(".money .input_m").attr("placeholder","请输入原因");
     $(".money .input_m").val('');
    $(this).removeClass('transPrice').addClass("inputPrice");
  });
  $(document).on("click",'.inputPrice',function(){
    $(".money .input_m").attr("placeholder","请输入价格");
    $(".money .input_m").val('');
    $(this).removeClass('inputPrice').addClass("transPrice");
  });
  //提交价格
  $(document).on("click",'.submitPrice',function(){
      var project_id = $(".price-hidden").find("input[name='project_id']").val();
      var place_id = $(".price-hidden").find("input[name='place_id']").val();
      var goods_id = $(".price-hidden").find("input[name='goods_id']").val();
      var price = $(".money .input_m").val();
      $.post('/front/project/price',{project_id:project_id,place_id:place_id,goods_id:goods_id,price:price},function(data){
          if(data.sta == 0){
            alert(data.msg);
          }else{
            $("li[data-goodsid='"+goods_id+"']").find(".uped_price").html("("+price+")")
          }
      },'json');
  });  
})

$(function () {
    $('.changeattr_submit').bind('click', function () {
        $.post("/front/member/dochangeattr", $('#form_changeattr').serialize(), function (data) {
            alert(data.msg);
              if(data.sta == 1){
                  location.href = "/front/member/changeaccount";
              }
        }, 'json');
    });
});

