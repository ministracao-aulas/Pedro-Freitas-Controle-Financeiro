var l=Object.defineProperty;var i=(d,e,o)=>e in d?l(d,e,{enumerable:!0,configurable:!0,writable:!0,value:o}):d[e]=o;var a=(d,e,o)=>(i(d,typeof e!="symbol"?e+"":e,o),o);const r=class{static removeShowOnToggled(...e){document.querySelector("#accordionSidebar.toggled")&&document.querySelectorAll('[data-parent="#accordionSidebar"].collapse.show').forEach(o=>{console.log("exceptElements",e),!(e.length&&e.includes(o))&&o.classList.remove("show")})}static loadPreferences(){this.setSidebarMode(this.getSidebarMode("retract"))}callStatic(e,...o){var n;if(!e||((n=e==null?void 0:e.constructor)==null?void 0:n.name)!="String"||!(e in r)){console.log('Error on "staticMethod"',e);return}return r[e](...o)}};let t=r;a(t,"validSidebarMode",e=>e&&["expand","retract"].includes(e)),a(t,"getSidebarMode",(e=null)=>{let o=localStorage.getItem("sidebarMode");return e=r.validSidebarMode(e)?e:"retract",o&&r.validSidebarMode(o)?o:e}),a(t,"setSidebarMode",e=>{if(r.validSidebarMode(e)){if(localStorage.setItem("sidebarMode",e),e=="retract"){document.body.classList.add("sidebar-toggled"),document.querySelectorAll(".sidebar").forEach(o=>o.classList.add("toggled"));return}document.body.classList.remove("sidebar-toggled"),document.querySelectorAll(".sidebar").forEach(o=>o.classList.remove("toggled"))}}),a(t,"toggleSidebarMode",()=>{let o=r.getSidebarMode("expand")=="expand"?"retract":"expand";r.setSidebarMode(o)});window.PagePreferences=t;window.__preferences=new t;window.__preferences&&"callStatic"in window.__preferences&&(window.__preferences.callStatic("loadPreferences"),window.__preferences.callStatic("removeShowOnToggled"),window.removeShowOnToggled=(d,e)=>{window.counter=window.counter??0,console.log("fora",++window.counter,e),window.__preferences.callStatic("removeShowOnToggled")});document.addEventListener("DOMContentLoaded",d=>{document.querySelectorAll('[data-parent="#accordionSidebar"].collapse.to_show_on_load').forEach(e=>{e.classList.remove("to_show_on_load"),e.classList.add("show")}),window.__preferences.callStatic("removeShowOnToggled"),document.querySelectorAll('a[data-prevent-default-onclick="true"]').forEach(e=>e.addEventListener("click",o=>o.preventDefault(),!1))});
