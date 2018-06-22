var banner;
$(document).ready(function(e) {
        $("a").each(function(index, element) {
            var mail=$(this).html();
			if(mail.indexOf("@")!=-1)
			{
				mail=mail.replace("@","&#8203;@");
				console.log(mail);
				$(this).html(mail);
			}
        });
		banner=$('#banner').height();
		$(window).scroll(function() {
			$('#banner').css('top', $(this).scrollTop()+$(this).height()-banner + "px");
	});
    });

function menu(){
		if(jQuery("#menu-mobile").css("display")=="block")
			jQuery("#menu-mobile").css("display","none");
		else
			jQuery("#menu-mobile").css("display","block");
		return false;
	}
	
	
function validate(e){
	var form=e.id;
	var error;
	var name;
	var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
	
	$("#"+form).find("input").each(function(index, element) {
		name=$(this).attr("placeholder");
		error=false;
        if($(this).attr("required")=="required" && $(this).val()=="")
		{
			$(this).focus();
			$("#msg").html("*Please fill all required fields. ("+name+")");
			error=true;
			return false;
		}
		else
		{
			if($(this).attr("placeholder")==$(this).val())
			{
				$(this).focus();
				$("#msg").html("*Please fill all required fields. ("+name+")");
				error=true;
				return false;
			}
			
			else
			{
				if($(this).attr("type")=="email" && !pattern.test($(this).val()))
				{
					$(this).focus();
					$("#msg").html("*Please use a valid email address.");
					error=true;	
					return false;
				}
			}
		}
		
    });
	
	if(error===true)
		return false;
	else
	{
		$("#"+form).find("textarea").each(function(index, element) {
		error=false;
		 if($(this).attr("required")=="required" && $(this).val()=="")
			{
				$(this).focus();
				$("#msg").html("*Please fill all required areas.");
				error=true;
				return false;
			}
		
		});
		
		if(error===true)
			return false;
	
	}
}