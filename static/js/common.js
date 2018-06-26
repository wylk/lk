var lk = {
	up_img:function(inputfile,up_path,backfunc,dataType){
		var data = new FormData();
        $.each(inputfile[0].files, function(i, file) {
            data.append('file', file);
        });
        $.ajax({
            url:up_path,
            type:'POST',
            data:data,
            dataType:dataType,
            cache: false,
            contentType: false,    //不可缺
            processData: false,    //不可缺
            success:backfunc
        });
	},
    checkbox_val:function(name){
        var standards = "";
        $("input:checkbox[name="+name+"]:checked").each(function() {
            standards += "," + $(this).val();
        });
        return standards;
    }
}

