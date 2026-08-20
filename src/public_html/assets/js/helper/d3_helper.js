var d3_helper = {
	svg:null
	,svg_id:null
	,force_setting:null
	,tick:null
	,draw:function(svg_id,type,data,custom_elemts)
	{
		d3_helper.svg = d3.select("#"+svg_id);
		d3_helper.svg_id = svg_id;
		if(type=="force")
		{
			d3_helper.force(data,custom_elemts);
		}
	}
	,force:function(data,custom_elemts){
		if(typeof data.nodes == "undefined")
		{
			alert("d3 force graph missing data.nodes");
		}
		if(typeof data.links == "undefined")
		{
			alert("d3 force graph missing data.links");
		}
		var colors = d3.scale.category10();
		var width = $("#"+d3_helper.svg_id).width();
		var height = $("#"+d3_helper.svg_id).height();
		var linkDistance = 200;
		var charge = [-500];
		var theta = 0;
		var gravity = 0.05;
		var node_round = 30;
		if(typeof custom_elemts.linkDistance != "undefined")
		{
			linkDistance = custom_elemts.linkDistance;
		}
		if(typeof custom_elemts.charge != "undefined")
		{
			charge = custom_elemts.charge;
		}
		if(typeof custom_elemts.theta != "undefined")
		{
			theta = custom_elemts.theta;
		}
		if(typeof custom_elemts.gravity != "undefined")
		{
			gravity = custom_elemts.gravity;
		}
		for(var i=0; i < data.links.length; i++)
		{
			for(var n=0; n < data.nodes.length; n++)
			{
				if(data.links[i].source == data.nodes[n].id)
				{
					data.links[i].source = n;
					break;
				}
			}
			for(var n=0; n < data.nodes.length; n++)
			{
				if(data.links[i].target == data.nodes[n].id)
				{
					data.links[i].target = n;
					break;
				}
			}
			
		}
		d3_helper.force_setting = d3.layout.force()
	        .nodes(data.nodes)
	        .links(data.links)
	        .size([width,height])
	        .linkDistance([linkDistance])
	        .charge(charge)
	        .theta(theta)
	        .gravity(gravity)
	        .start();
		var edges = d3_helper.svg.selectAll("line")
	      .data(data.links)
	      .enter()
	      .append("line")
	      .attr({"id":function(d,i) {return 'edge'+i},"class":"relationship","stroke-width":7})
	      .attr('marker-end',function(d,i){return d3_helper.force_marker(d3_helper.svg,i,d.color,custom_elemts);})
		  //.attr({'d': function(d) {return 'M '+d.source.x+' '+d.source.y+' L '+ d.target.x +' '+d.target.y}})
	      .style("stroke",function(d){
			return d.color;
		  });
		  
		var nodes = d3_helper.svg.selectAll("circle")
	      .data(data.nodes)
	      .enter()
	      .append("circle")
	      .attr({"r":node_round, "class":"cc", 'id':function(d,i) {return 'circile_'+d.id;}})
	      .style("fill",function(d,i){return data.nodes[i].color;})
	      .call(d3_helper.force_setting.drag);
	    var nodelabels = d3_helper.svg.selectAll(".nodelabel") 
	       .data(data.nodes)
	       .enter()
	       .append("text")
	       .attr({"x":function(d){return d.x;},
	              "y":function(d){return d.y;},
	              "class":"nodelabel",
	              "stroke":"black"})
	       .text(function(d){return d.name;});
	   	var edgepaths = d3_helper.svg.selectAll(".edgepath")
	        .data(data.links)
	        .enter()
	        .append('path')
	        .attr({'d': function(d) {return 'M '+d.source.x+' '+d.source.y+' L '+ d.target.x +' '+d.target.y;},
			//.attr({'d': function(d) {return 'M '+d.source.x+','+d.source.y+' C'+(d.source.x/2)+','+(d.source.y/2)+' '+(d.target.x/2)+','+(d.target.y/2)+' '+ d.target.x +' '+d.target.y},
			//.attr({'d': function(d) {return 'M '+d.source.x+','+d.source.y+' C 300,200 300,200 '+ d.target.x +' '+d.target.y},
	               'class':'edgepath',
	               'fill-opacity':0,
	               'stroke-opacity':0,
	               'fill':'blue',
	               'stroke':'red',
	               'id':function(d,i) {return 'edgepath'+i;}});
	     var edgelabels = d3_helper.svg.selectAll(".edgelabel")
        .data(data.links)
        .enter()
        .append('text')
		.style("edge-text-rotation","autorotate")
        .attr({'class':'edgelabel',
               'id':function(d,i){return 'edgelabel'+i;},
               'dx':50,
               'dy':-10,
               'font-size':10,
               'fill':'#aaa'});
		var edgelabels2 = d3_helper.svg.selectAll(".edgelabel2")
	        .data(data.links)
	        .enter()
	        .append('text')
			.style("edge-text-rotation","autorotate")
	        .attr({'class':'edgelabel2',
	               'id':function(d,i){return 'edgelabel2'+i;},
	               'dy':-10,
	               'font-size':10,
	               'fill':'#aaa'});
	
	    edgelabels.append('textPath')
	        .attr('xlink:href',function(d,i) {return '#edgepath'+i;})
	        .text(function(d,i){return d.source_label;})
			.style("edge-text-rotation","autorotate");
			
		edgelabels2.append('textPath')
	        .attr('xlink:href',function(d,i) {return '#edgepath'+i;})
	        .text(function(d,i){return d.target_label;})
			.style("edge-text-rotation","autorotate");
			
		 d3_helper.svg.selectAll(".nodelabel").each(d3_helper.insertLinebreaks);
		
		d3_helper.tick = d3_helper.force_setting.on("tick", function(){
			
			width = $("#"+d3_helper.svg_id).width();
			height = $("#"+d3_helper.svg_id).height();
			d3_helper.force_setting.size([width,height]);
			nodes[0].x = width/2;
			nodes[0].y = height/2;
			
	        edges.attr({"x1": function(d){return d.source.x;},
	                    "y1": function(d){return d.source.y;},
	                    "x2": function(d){return d.target.x;},
	                    "y2": function(d){return d.target.y;}
	        });
			d3.selectAll(".edgelabel2").attr("dx",function(d,i){
				var bbox = this.getBBox();
				var txt_width = 0;
				if(bbox.height > bbox.width)
				{
					txt_width = bbox.height;
				}
				else
				{
					txt_width = bbox.width;
				}
				return (linkDistance-(txt_width)-node_round-40);
			});
	        nodes.attr({"cx":function(d){return d.x;},
	                    "cy":function(d){return d.y;}
	        });
	
	        nodelabels.attr("x", function(d) { return d.x; }) 
	                  .attr("y", function(d) { return d.y; })
	                  ;
	
	        edgepaths.attr('d', function(d) {
												
												var path='M '+d.source.x+' '+d.source.y+' L '+ d.target.x +' '+d.target.y;
											   //path = 'M '+d.source.x+','+d.source.y+' C'+(d.source.x)+','+(d.source.y/2)+' '+(d.target.x)+','+(d.target.y/2)+' '+ d.target.x +' '+d.target.y;
											   var dx = d.target.x - d.source.x,
												dy = d.target.y - d.source.y,
												dr = Math.sqrt(dx * dx + dy * dy);
												//path =  "M" + d.source.x + "," + d.source.y + "A" + dr + "," + dr + " 0 0,1 " + d.target.x + "," + d.target.y;
	                                           return path});
			edges.attr("d", function(d) {
				var dx = d.target.x - d.source.x,
					dy = d.target.y - d.source.y,
					dr = Math.sqrt(dx * dx + dy * dy);
				return "M" + d.source.x + "," + d.source.y + "A" + dr + "," + dr + " 0 0,1 " + d.target.x + "," + d.target.y;
			});

	        edgelabels.attr('transform',function(d,i){
	            if (d.target.x<d.source.x){
	                bbox = this.getBBox();
	                rx = bbox.x+bbox.width/2;
	                ry = bbox.y+bbox.height/2;
	                return 'rotate(180 '+rx+' '+ry+')';
	                }
	            else {
	                return 'rotate(0)';
	                }
	        });

			edgelabels2.attr('transform',function(d,i){
			
	            if (d.target.x<d.source.x){
	                bbox = this.getBBox();
	                rx = bbox.x+bbox.width/2;
	                ry = bbox.y+bbox.height/2;
	                return 'rotate(180 '+rx+' '+ry+')';
	                }
	            else {
	                return 'rotate(0)';
	                }
	        });
	    });
	}
	,force_marker:function(svg,id,color,custom_elemts){
		var markerWidth = 3;
		var markerHeight = 4;
		var refX = 22;
		var refY = 0;
		if(typeof custom_elemts.marker != "undefined")
		{
			if(typeof custom_elemts.marker.width != "undefined")
			{
				markerWidth = custom_elemts.marker.width;
			}
			if(typeof custom_elemts.marker.height != "undefined")
			{
				markerHeight = custom_elemts.marker.height;
			}
			if(typeof custom_elemts.marker.refX != "undefined")
			{
				refX = custom_elemts.marker.refX;
			}
			if(typeof custom_elemts.marker.refY != "undefined")
			{
				refY = custom_elemts.marker.refY;
			}
		}
		
		d3_helper.svg.append('defs').append('marker')
        .attr({'id':'arrowhead'+id,
               'viewBox':'-0 -5 10 10',
               'refX':refX,
               'refY':refY,
               //'markerUnits':'strokeWidth',
               'orient':'auto',
               'markerWidth':markerWidth,
               'markerHeight':markerHeight,
               'xoverflow':'visible'})
        .append('svg:path')
            .attr('d', 'M 0,-5 L 10 ,0 L 0,5')
            .attr('fill', color)
            .attr('stroke',color);
		return "url(#arrowhead"+id+")";
	}
	, insertLinebreaks: function (d) {
	    var el = d3.select(this);
	    var words = d.name.split('\n');
	    el.text('');
		var first_line_width = 0;
		var past_line_width = 0;
	    for (var i = 0; i < words.length; i++) {
	        var tspan = el.append('tspan').text(words[i]);
	        var measure_txt = d3_helper.svg.append("text").append("tspan").text(words[i]);
	        var measure_txt_width = measure_txt[0][0].getBBox().width;
	        measure_txt.remove();
	        if(i==0)
	        {
	        	first_line_width = this.getBBox().width;
	        }
	         if (i > 1)
	         {
	         	tspan.attr('dx', (-past_line_width/2)-(measure_txt_width/2)).attr('dy', '15');
	         	
	         }
	         else if(i > 0)
	         {
	         	tspan.attr('dx', (-first_line_width)/2-(measure_txt_width/2)).attr('dy', '15');
	         	past_line_width = measure_txt_width;
	         }
	         el.attr("dx",(-first_line_width)/2);
	    }
	}
};
