!function(t){t(function(){t.widget("zpd.paging",{options:{limit:5,rowDisplayStyle:"block",activePage:0,rows:[]},_create:function(){var a=t("tbody",this.element).children();this.options.rows=a,this.options.rowDisplayStyle=a.css("display");var e=this._getNavBar();this.element.after(e),this.showPage(0)},_getNavBar:function(){for(var a=this.options.rows,e=t("<div>",{"class":"paging-nav"}),i=0;i<Math.ceil(a.length/this.options.limit);i++)this._on(t("<a>",{href:"#",text:i+1,"data-page":i}).appendTo(e),{click:"pageClickHandler"});return this._on(t("<a>",{href:"#",text:"<<","data-direction":-1}).prependTo(e),{click:"pageStepHandler"}),this._on(t("<a>",{href:"#",text:">>","data-direction":1}).appendTo(e),{click:"pageStepHandler"}),e},showPage:function(a){var e=1*a;this.options.activePage=e;for(var i=this.options.rows,s=this.options.limit,n=0;n<i.length;n++)n>=s*e&&s*(e+1)>n?t(i[n]).css("display",this.options.rowDisplayStyle):t(i[n]).css("display","none")},pageClickHandler:function(a){a.preventDefault(),t(a.target).siblings().attr("class",""),t(a.target).attr("class","selected-page");var e=t(a.target).attr("data-page");this.showPage(e)},pageStepHandler:function(a){a.preventDefault();var e=1*t(a.target).attr("data-direction"),i=this.options.activePage+e;i>=0&&i<this.options.rows.length&&t("a[data-page="+i+"]",t(a.target).parent()).click()}})})}(jQuery);