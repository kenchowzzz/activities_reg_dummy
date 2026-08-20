var utils = {
	text:{
		null_return_empty_str:function(val){
			if(val == null)
			{
				val = "";
			}
			return val;
		},
		thousand_separator: function (nStr) {
		    nStr += '';
		    var x = nStr.split('.');
		    var x1 = x[0];
		    var x2 = x.length > 1 ? '.' + x[1] : '';
		    var rgx = /(\d+)(\d{3})/;
		    while (rgx.test(x1)) {
		        x1 = x1.replace(rgx, '$1' + ',' + '$2');
		    }
		    return x1 + x2;
		}
	},
	base_url:function(){
		return $("#base_url").val();
	}
	,array:{
		remove_by_value:function(ids,values)
		{
			var tmp_val = [];
			for(var i=0;i<values.length;i++)
			{
				tmp_val.push(values[i]);
			}
			for(var i=0; i<tmp_val.length;i++)
			{
				var value = tmp_val[i];
				if(typeof ids != "undefined")
				{
					if(ids.length > 0)
					{
						var index = ids.indexOf(value);
						if (index >= 0) {
						  ids.splice( index, 1 );
						}
					}
				}
				
				
			}
		},
		in_array: function(val, arr) {
			for(var i=0; i<arr.length; i++) {
		        if (arr[i] == val) return true;
		    }
		    return false;
		}
	},
	thousand_seperators:function(value){
		var number = parseFloat(value);
		number+= 0.00;
		return number.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
	},
	form_thousand_seperators:function(){
		$(".dollor_seperator").each(function(){
			if($(this).is(":disabled") || $(this).is("[readonly]"))
			{
				if($(this).val() != "")
				{
					$(this).val(utils.thousand_seperators($(this).attr("value")));
				}
				
			}
		});
	}
};
