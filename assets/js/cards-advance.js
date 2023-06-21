"use strict";!function(){let o,e,r,t;isDarkStyle?(o=config.colors_dark.cardColor,t=config.colors_dark.textMuted,r=config.colors_dark.bodyColor,e=config.colors_dark.headingColor):(o=config.colors.cardColor,t=config.colors.textMuted,r=config.colors.bodyColor,e=config.colors.headingColor);const a=document.querySelectorAll(".chart-progress");a&&a.forEach((function(o){const e=function(o,e){return{chart:{height:55,width:45,type:"radialBar"},plotOptions:{radialBar:{hollow:{size:"25%"},dataLabels:{show:!1},track:{background:config.colors_label.secondary}}},colors:[o],grid:{padding:{top:-15,bottom:-15,left:-5,right:-15}},series:[e],labels:["Progress"]}}(config.colors[o.dataset.color],o.dataset.series);new ApexCharts(o,e).render()}));const s=document.querySelector("#orderStatisticsChart"),i={chart:{height:165,width:130,type:"donut"},labels:["Electronic","Sports","Decor","Fashion"],series:[85,15,50,50],colors:[config.colors.primary,config.colors.secondary,config.colors.info,config.colors.success],stroke:{width:5,colors:[o]},dataLabels:{enabled:!1,formatter:function(o,e){return parseInt(o)+"%"}},legend:{show:!1},grid:{padding:{top:0,bottom:0,right:15}},plotOptions:{pie:{donut:{size:"75%",labels:{show:!0,value:{fontSize:"1.5rem",fontFamily:"Public Sans",color:e,offsetY:-15,formatter:function(o){return parseInt(o)+"%"}},name:{offsetY:20,fontFamily:"Public Sans"},total:{show:!0,fontSize:"0.8125rem",color:r,label:"Weekly",formatter:function(o){return"38%"}}}}}},states:{active:{filter:{type:"none"}}}};if(void 0!==typeof s&&null!==s){new ApexCharts(s,i).render()}const n=document.querySelector("#reportBarChart"),l={chart:{height:200,type:"bar",toolbar:{show:!1}},plotOptions:{bar:{barHeight:"60%",columnWidth:"60%",startingShape:"rounded",endingShape:"rounded",borderRadius:4,distributed:!0}},grid:{show:!1,padding:{top:-20,bottom:0,left:-10,right:-10}},colors:[config.colors_label.primary,config.colors_label.primary,config.colors_label.primary,config.colors_label.primary,config.colors.primary,config.colors_label.primary,config.colors_label.primary],dataLabels:{enabled:!1},series:[{data:[40,95,60,45,90,50,75]}],legend:{show:!1},xaxis:{categories:["Mo","Tu","We","Th","Fr","Sa","Su"],axisBorder:{show:!1},axisTicks:{show:!1},labels:{style:{colors:t,fontSize:"13px"}}},yaxis:{labels:{show:!1}}};if(void 0!==typeof n&&null!==n){new ApexCharts(n,l).render()}const c=document.querySelector("#conversionRateChart"),d={chart:{height:80,width:140,type:"line",toolbar:{show:!1},dropShadow:{enabled:!0,top:10,left:5,blur:3,color:config.colors.primary,opacity:.15},sparkline:{enabled:!0}},markers:{size:6,colors:"transparent",strokeColors:"transparent",strokeWidth:4,discrete:[{fillColor:o,seriesIndex:0,dataPointIndex:3,strokeColor:config.colors.primary,strokeWidth:4,size:6,radius:2}],hover:{size:7}},grid:{show:!1,padding:{right:8}},colors:[config.colors.primary],dataLabels:{enabled:!1},stroke:{width:5,curve:"smooth"},series:[{data:[137,210,160,245]}],xaxis:{show:!1,lines:{show:!1},labels:{show:!1},axisBorder:{show:!1}},yaxis:{show:!1}};new ApexCharts(c,d).render();const h=document.querySelector(".credit-card-payment"),p=document.querySelector(".expiry-date-payment"),g=document.querySelectorAll(".cvv-code-payment");let f;h&&(f=new Cleave(h,{creditCard:!0,onCreditCardTypeChanged:function(o){document.querySelector(".card-payment-type").innerHTML=""!=o&&"unknown"!=o?'<img src="'+assetsPath+"img/icons/payments/"+o+'-cc.png" class="cc-icon-image" height="28"/>':""}})),p&&new Cleave(p,{date:!0,delimiter:"/",datePattern:["m","y"]}),g&&g.forEach((function(o){new Cleave(o,{numeral:!0,numeralPositiveOnly:!0})}))}();
