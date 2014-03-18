function MENU(config, updater, menu_id, skin) {

    var menu_node = document.getElementById(menu_id);
    if (isIE()) menu_node.style.zIndex = 400; // should be below dialog z-index

    var skin = false;
    
    var re = /dhtmlxmenu_(.*).css$/;
    for (var i=0;i<document.styleSheets.length;i++) {
	if ((document.styleSheets[i])&&(document.styleSheets[i].href)) {
	    var href = document.styleSheets[i].href;
	    if (m = re.exec(href)) {
		skin = m[1];
		break;
	    }
	}
    }
    
    if (!skin) adeiReportError("No DHTMLX skin is loaded, check if dhtmlx css files are in place");



/*   
    v.1
    this.aMenuBar = new dhtmlXMenuBarObject(menu_node);
    this.aMenuBar.setOnClickHandler(this.onClick(this));
    this.aMenuBar.setGfxPath("images/");
    this.aMenuBar.setZIndex(1000);
*/


    this.aMenuBar = new dhtmlXMenuObject(menu_id, skin);
    this.aMenuBar.setImagePath("includes/dhtmlx/imgs/");
    this.aMenuBar.setIconsPath("images/");
    this.aMenuBar.attachEvent("onClick", this.onClick(this));


    this.config = config;
    if (config) config.Register(this);
    
    this.updater = updater;

    this.window = null;
    this.exporter = null;
}

MENU.prototype.Load = function() {
    this.ReLoad();
}

MENU.prototype.AttachWindow = function(wnd) {
    this.window = wnd;
}

MENU.prototype.AttachExporter = function(exp) {
    this.exporter = exp;
}

MENU.prototype.OnLoad = function(self) {
    return function() {
	if (adei.cfg.menu_scroll_limit) {
	    self.aMenuBar.setOverflowHeight(adei.cfg.menu_scroll_limit);
	}
    }
}

MENU.prototype.ReLoad = function() {

    this.aMenuBar.loadXML(adei.GetServiceURL("menu"), this.OnLoad(this));


//    this.aMenuBar.enableDynamicLoading(adei.GetServiceURL("menu"));
//    this.aMenuBar.showBar();
    // fix popups if placed in sidebar which is in super mode
}

MENU.prototype.SetQuery = function(srv, db, grp, mask, exp) {
	// This will force reset of time range (independent of other settings)
    if (typeof exp == "undefined") exp = "0-0";

    this.config.ApplyDataSource(srv,db,grp,undefined,mask,exp);
}

MENU.prototype.SetSource = function(srv, db, grp, mask) {
    this.config.ApplyDataSource(srv,db,grp,undefined,mask);
}

MENU.prototype.SetWindow = function(width) {
    if (this.window) {
	this.window.UpdateWidth(width);
    }
}

MENU.prototype.SetFormat = function(format) {
    if (this.exporter) {
	this.exporter.SetFormat(format);
    }
}

MENU.prototype.SetExportSampling = function(sampling) {
    if (this.exporter) {
	this.exporter.SetSampling(sampling);
    }
}

MENU.prototype.LockWindow = function() {
    if (this.window) this.window.Lock();
}

MENU.prototype.ReDraw = function() {
    if (this.updater) this.updater.Update();
}

MENU.prototype.ExportWindow = function() {
    if (this.exporter) {
	this.exporter.Export(true, 0);
    }
}

MENU.prototype.SetExportMask = function(mask) {
    if (this.exporter) {
	this.exporter.SetMask(mask);
    }
}

MENU.prototype.onClick = function(self) {
    return function(itemId,itemValue) {
	var params = itemId.split("__");
	if (params[0] == "folder") return;
	    
	var args = "";
	if (params.length > 1) {
	    args = "\"" + params[1] + "\"";
	    for (var i = 2; i < params.length; i++)
		args += ", \"" + params[i] + "\"";
	}
	
	var cmd = "if (typeof self." + params[0] + " == \"function\") {" +
	    "self." + params[0] + "(" + args + ");" +
	"} else {" +
	    "adeiReportError(\"Invalid menu action (" + params[0] + ")\", \"MENU\");" +
	"}";
	
	eval(cmd);	
    }
}

 