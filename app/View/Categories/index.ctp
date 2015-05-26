
<?php 
        $this->extend('/common/header');
        $this->assign('title','List of Categories');
?>
<style>
      .legend {                                                  
        font-size: 12px;                                         
    }                                                          
     
      rect {                                                     
        stroke-width: 2;                                         
    }     
     
      #chart {
          height: 400px;
          position: relative;
          width: 800px;
    } 

    .tooltip {
      background: #eee;
      box-shadow: 0 0 5px #999999;
      color: #333;
      display: none;
      font-size: 12px;
      left: 130px;
      padding: 10px;
      position: absolute;
      text-align: center;
      top: 95px;
      width: 80px;
      z-index: 10;
    }                                                     
</style>

<script src="http://d3js.org/d3.v3.min.js" type="text/javascript" charset="utf-8"></script>
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js'></script>
  
<table>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Length_type</th>
        <th>Actions</th>
    </tr> 
    <?php echo $this->Html->link('Add new Category',array('controller'=>'categories','action'=>'add'));?>
    
    <?php foreach ($categories as $category): ?>    
    <tr>
        <td><?php echo h($category['Category']['id']); ?></td>
        <td>
            <?php echo $this->Html->link($category['Category']['name'],
                    array('controller'=> 'categories','action' => 'view',$category['Category']['id']));?>
        </td>
        <td>        
            <?php echo h($category['Category']['length_type']);?>
        </td>

        <td>
            <?php echo $this->Html->link('Edit', array('controller' => 'categories', 'action' => 'edit',$category['Category']['id'])); ?>            
        </td> 
    </tr>
    <?php endforeach; ?> 
    
    <?php unset($category); ?>
</table>
<div id="chart"></div>
<script type="text/javascript">

        var w = 800;
        var h = 400;
        var r = h/2;
        var data = [];
        var text;
        var color = d3.scale.category20c();

        var legendRectSize = 18;                                  
        var legendSpacing = 4;                                    
       
        <?php foreach ($categories as $category): ?>  

            if(<?php echo count($category['Game'])?> > 0){
                data.push({"label":<?php echo "\"" . $category['Category']['name'] . "\"";?>, "value":<?php echo count($category['Game'])?>});
            }  
                
        <?php endforeach;?>


        var vis = d3.select('#chart').append("svg:svg").data([data]).attr("width", w).attr("height", h).append("svg:g").attr("transform", "translate(" + r + "," + r + ")");

        var pie = d3.layout.pie().value(function(d){return d.value;});

        // declare an arc generator function
        var arc = d3.svg.arc().outerRadius(r);

        // select paths, use arc generator to draw
        var arcs = vis.selectAll("g.slice").data(pie).enter().append("svg:g").attr("class", "slice");
        arcs.append("svg:path")
            .attr("fill", function(d, i){
                return color(i);
            })
            .attr("d", function (d) {               
                console.log(arc(d));
                return arc(d);
            });

        //mouseover event
        arcs.on('mouseover', function(d) {                           

              tooltip.select('.label').html(d.data.label);
              tooltip.select('.value').html('Total:' + d.data.value);               
              tooltip.style('display', 'block');
        });  

        //mouseout event
        arcs.on('mouseout', function(){
            tooltip.style('display', 'none');
        });
            
        /*
        // add the text
        arcs.append("svg:text").attr("transform", function(d){
                    d.innerRadius = 0;
                    d.outerRadius = r;
            return "translate(" + arc.centroid(d) + ")";}).attr("text-anchor", "middle").text( function(d, i) {
            return data[i].label;}
                );
        */

        // adding legend
        var legend = vis.selectAll('.legend')                   
          .data(color.domain())                                 
          .enter()                                              
          .append('g')                                          
          .attr('class', 'legend')                              
          .attr('transform', function(d, i) {                   
            var height = legendRectSize + legendSpacing;          
            var offset =  height * color.domain().length / 2;     
            var horz =  legendRectSize * 13;                     
            var vert = i * height - offset;                      
            return 'translate(' + horz + ',' + vert + ')';       
          });                                                    

        legend.append('rect')                                     
          .attr('width', legendRectSize)                          
          .attr('height', legendRectSize)                         
          .style('fill', color)                                   
          .style('stroke', color);                                
          
        legend.append('text')                                     
          .attr('x', legendRectSize + legendSpacing)              
          .attr('y', legendRectSize - legendSpacing)              
          .text(function(d,i) { return data[i].label; });    


        // mousehover action on pie
        var tooltip = d3.select('#chart')         
                      .append('div')                       
                      .attr('class', 'tooltip');           

                    tooltip.append('div')                  
                      .attr('class', 'label');            

                    tooltip.append('div')                 
                      .attr('class', 'value');            

</script>
