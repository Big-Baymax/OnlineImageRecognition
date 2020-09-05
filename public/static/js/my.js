$(function() {
	try{
        $.validator.setDefaults({
            highlight: function (e) {
                $(e).closest(".form-group").removeClass("has-success").addClass("has-error")
            },
            success: function (e) {
                e.closest(".form-group").removeClass("has-error").addClass("has-success")
            },
            errorElement: "span", errorPlacement: function (e, r) {
                e.appendTo(r.is(":radio") || r.is(":checkbox") ? r.parent().parent().parent() : r.parent())
            },
            errorClass: "help-block", validClass: "help-block"
        })
	}catch (e){
		console.log('validator未导入');
	}

})
//基于 jqury-comfirm.js的message弹出框
function messagedialog(mes,time,icon,title){
	var mes = mes||"不要着急哦，有问题找客服哦！";
    var time = time||1000;
    var icon = icon||"";
    var title = title||"";
		$.dialog({
					title: title,
			        icon: icon,
					//useBootstrap: false,
					//containerFluid:true,
					// boxWidth:'min-width:150px',

					// columnClass: 'dialogcontent',
					// bootstrapClasses: {
					// 	container: 'container text-center',
					// 	containerFluid: 'dialogcon',
					// 	row: 'row',
					// },
					content: mes,
					closeIcon: false,
					backgroundDismiss: true,
					bgOpacity: null,
					onOpen: function() {
						// after the modal is displayed.
						var self = this;
						setTimeout(function() {
							self.close();
						}, time);
					},
					theme: 'dark'
				});
}

function test(form){
	var vb = form.data('bootstrapValidator');
				vb.validateField("email");
				alert(vb.isValidField("email"));
}

//获取邮箱验证码防止刷新
//setvalidCodetime(time)
function setvalidCodetime(time,email) {
	//location.href作为页面的唯一标识，可能有很多页面需要获取验证码。
	localStorage.setItem("Codetime_"+ location.href, time);
	localStorage.setItem("email_"+ location.href, email);
	localStorage.setItem("time_"+ location.href, new Date().getTime());
}

//getvalidCodetime()
function getvalidCodetime() {
	var LocalDelay = {};
	LocalDelay.Codetime = localStorage.getItem("Codetime_"+ location.href);
	LocalDelay.email = localStorage.getItem("email_"+ location.href);
	LocalDelay.time = localStorage.getItem("time_"+ location.href);
	return LocalDelay;
}

//邮箱验证码防止刷新自动执行器

//获取邮箱验证码
function getvalidCode(form,btn,email,emailcode,time,url){
	var url = url||"";//获取验证码地址
	var vb = form.data('bootstrapValidator');//验证表单
	var validCode = true;//是否获取超时标记
	var code = btn;//获取按钮对象
	var validCodetime = getvalidCodetime();//获取本机缓存对象防止刷新
	var timeLine = parseInt((new Date().getTime() - validCodetime.time) / 1000);//计算时间过去多久了
	if(timeLine < validCodetime.Codetime){
		time = validCodetime.Codetime - timeLine;
		email.val(validCodetime.email);
		validCode = false;
		var t = setInterval(function (){
			time--;
			setvalidCodetime(time,email.val());
			code.attr("disabled","disabled").html("已发送(" + time + ")s");
			if (time == 0){
				clearInterval(t);
				code.removeAttr("disabled").html("重新获取").addClass("fa fa-refresh");
				validCode = true;
			}
		}, 1000)
	}else{
		vb.validateField("email");//指定验证email表单
	    vb.validateField("code");//指定验证code表单
		if(vb.isValidField("email") && vb.isValidField("code")){
			if (validCode) {
				validCode = false;
				code.removeClass("fa fa-refresh");
				//传回后台发送手机验证码
				$.ajax({
					url: url,
					type: 'POST',
					data: {
						email: email.val(),
						code: emailcode.val()
					},
                    beforeSend:function(){
                        messagedialog('不要着急哦！',1000,'fa fa-spinner fa-spin',"发送中……");
					},
					success: function (result) {
							if (!result.status) {
								validCode = true;
								$(".imgcode").click();
								messagedialog(result.msg);
							} else {
								messagedialog('已发送，注意查收！');
								code.html("请稍后");
								var t = setInterval(function () {
									time--;
									setvalidCodetime(time,email.val());
									code.attr("disabled","disabled").html("已发送(" + time + ")s");
									if (time == 0) {
										clearInterval(t);
										code.removeAttr("disabled").html("重新获取").addClass("fa fa-refresh");
										validCode = true;
									}
								}, 1000)
							}
					},
					error: function () {
						messagedialog('获取失败请重试！');
					}
				});
			}
		}else{
			
		}
			
		}
	}

