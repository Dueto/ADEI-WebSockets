<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0"  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="utf-8"/>  
  <xsl:template match="result">
  <div>
   <div><h1>Download Manager</h1></div>
    <table>
      <tr>	      
	<th width="18%">User</th>
	<th>Data</th>
	<th width="20%">Added</th>	    
	<th width="25%">Progress</th>
	<th width="100px">Tools</th>	      
      </tr>
	<xsl:for-each select="download">
	  <xsl:if test="@sort='true'">
	    <tr>
	    <td>
	      <div>
		<xsl:value-of select="@user"/>
	      </div>
	      <xsl:if test="@owner != 'true'">
		<div class="dlsort_down" title="Sort downloads from this IP down" style="cursor:pointer" onmouseover="document.body.style.cursor='default'">
		  <xsl:attribute name="onclick">javascript:dlmanager.SortBy('<xsl:value-of select="@user"/>')</xsl:attribute>
		</div>
	      </xsl:if>
	    </td>  
	    <td>
	     <div class="downloadData" style=" min-width: 200px;">
	      <table>
		<tr>
		  <td><u>Source:</u></td>	
		  <td style="white-space: no-wrap;"><xsl:value-of select="@dl_name"/><br></br></td>
		</tr><tr>
		  <td><u>Window:</u></td>
		  <td style=""><xsl:value-of select="@detwindow"/><br></br></td>
		</tr><tr>
		  <td><u>Format:</u></td>
		  <td style=""><xsl:value-of select="@format"/><br></br></td>
		</tr>
	      </table>
	     </div>
	    </td>
	    <td><xsl:value-of select="@startdate"/></td>
	    <td>	
	      <xsl:if test="@status='Queue'">	
		<div class="progress_container" id="progress_container">
		<div class="progressQueue">Queue</div></div>
		<div style="font-size:11px">
		  <xsl:attribute name="id">fcount<xsl:value-of select="@dl_id"/></xsl:attribute>
		</div>	      
	      </xsl:if>
	      <xsl:if test="@status='ERROR'">	
		<div class="progress_container" id="progress_container">
		    <div class="progressQueue"><font color="#FF0000">Error!</font></div>
		</div>	
	      </xsl:if>
	      <xsl:if test="@status='Finalizing'"> 
		<div class="progress_container" id="progress_container">
		    <div class="progress" id="progress">Finalizing file...</div>
		</div>	    
	      </xsl:if>
	      <xsl:if test="@status='Ready'"> 
		<div class="progress_container" id="progress_container">
		    <div class="progressReady" id="progressReady">Complete (
			<xsl:if test="@filesize='0.1'"> &#60;1mb)</xsl:if> 
			<xsl:if test="@filesize!='0.1'"><xsl:value-of select="@filesize"/>mb)</xsl:if>
		    </div>
		</div>		
	      </xsl:if>
		<xsl:if test="@status='Preparing'">	
		<div class="progress_container" id="progress_container">
		    <div class="progress" style="width:0%">
			<xsl:attribute name="id">progress<xsl:value-of select="@dl_id"/></xsl:attribute>
		    </div>
		</div>
		<div style="font-size:11px">
		  <xsl:attribute name="id">fcount<xsl:value-of select="@dl_id"/></xsl:attribute>
		</div>
	      </xsl:if>
	    </td>	
	    <td>
	    <div class="buttoncontainer" borderwidth="0">
	      <table cellspacing="0" cellpadding="0"><tr>
		<td><div class="previewimg" title="Show graph" style="cursor:pointer;">
		  <xsl:attribute name="onclick">javascrip:tooltip.Show(event,'<xsl:value-of select="@dl_id"/>')</xsl:attribute>
		</div></td>
		<td><div class="infoimg" title="Show details" style="cursor:pointer" >
		  <xsl:attribute name="onclick">javascript:tooltipdet.Show(event,'<xsl:value-of select="@dl_id"/>', 'true')</xsl:attribute>
		</div></td>
		<td><div class="downloadimg" title="Download file" style="cursor:pointer">
		  <xsl:if test="@status='Ready'">
		    <xsl:attribute name="onclick">javascript:data_export.StartDownload('<xsl:value-of select="@dl_id"/>','<xsl:value-of select="@format"/>','<xsl:value-of select="@dl_name"/>','<xsl:value-of select="@ctype"/>')</xsl:attribute>
		  </xsl:if>
		</div></td>
		<td><div class="deleteimg" title="Delete download" style="cursor:pointer">
		  <xsl:attribute name="onclick">javascript:dlmanager.RemoveDownload('<xsl:value-of select="@dl_id"/>')</xsl:attribute>	
		</div></td>
	      </tr></table>	      
	    </div>
	    <div title="Uncheck to prevent deleting download automatically when unused">
	      <xsl:attribute name="onmouseover">javascript:showText('auto_delete<xsl:value-of select="@dl_id"/>')</xsl:attribute>
	      <xsl:attribute name="onmouseout">javascript:clearText('auto_delete<xsl:value-of select="@dl_id"/>')</xsl:attribute>
	      <div style="float:right; margin-right:1px; width:20px;">		
		<input type="checkbox">
		    <xsl:attribute name="name">auto_delete_cb<xsl:value-of select="@dl_id"/></xsl:attribute>
		    <xsl:if test="@auto_delete='true'">
			<xsl:attribute name="checked"></xsl:attribute>
		    </xsl:if>		
		    <xsl:attribute name="onclick">javascript:dlmanager.ToggleAutodelete('<xsl:value-of select="@dl_id"/>')</xsl:attribute>
		</input>
	      </div>
	      <div style="/*float:left;*/ text-align:left;">
		<xsl:attribute name="id">auto_delete<xsl:value-of select="@dl_id"/></xsl:attribute>		       
	      </div>
	    </div>
	    </td>
	    </tr>  
	  </xsl:if>	 
	</xsl:for-each>      
    </table>    
    <div style="text-align:center"><h4>Downloads from different IP</h4></div>
    <table>
      <tr>	      
	<th width="18%">User</th>
	<th>Data</th>
	<th width="20%">Added</th>	    
	<th width="25%">Progress</th>
	<th width="100px">Tools</th>	      
      </tr>
      <xsl:for-each select="download">
	  <xsl:if test="@sort='rest'">
	    <tr>
	     <td><div><xsl:value-of select="@user"/></div>	    
	      <div class="dlsort" title="Sort downloads from this IP up" style="cursor:pointer" onmouseover="document.body.style.cursor='default'">
		<xsl:attribute name="onclick">javascript:dlmanager.SortBy('<xsl:value-of select="@user"/>')</xsl:attribute>
	      </div>	   
	    </td>  
	    <td>
	    <div class="downloadData" style=" min-width: 200px;">
	      <table>
		<tr>
		  <td><u>Source:</u></td>	
		  <td style="white-space: no-wrap;"><xsl:value-of select="@dl_name"/><br></br></td>
		</tr><tr>
		  <td><u>Window:</u></td>
		  <td style=""><xsl:value-of select="@detwindow"/><br></br></td>
		</tr><tr>
		  <td><u>Format:</u></td>
		  <td style=""><xsl:value-of select="@format"/><br></br></td>
		</tr>
	      </table>
	    </div>
	    </td>
	    <td><xsl:value-of select="@startdate"/></td>
	    <td>	
	      <xsl:if test="@status='Queue'">	
		<div class="progress_container" id="progress_container">
		<div class="progressQueue">Queue</div></div>	
	      </xsl:if>
	      <xsl:if test="@status='ERROR'">	
		<div class="progress_container" id="progress_container">
		<div class="progressQueue"><font color="#FF0000">Error!</font></div></div>	
	      </xsl:if>
	      <xsl:if test="@status='Finalizing'"> 
		<div class="progress_container" id="progress_container">
		<div class="progress" id="progress">Finalizing file...</div></div>
	      </xsl:if>
	      <xsl:if test="@status='Ready'"> 
		<div class="progress_container" id="progress_container">
		<div class="progressReady" id="progressReady">Complete (
		  <xsl:if test="@filesize='0.1'"> &#60;1mb)</xsl:if> 
		  <xsl:if test="@filesize!='0.1'"><xsl:value-of select="@filesize"/>mb)</xsl:if>
		</div></div>
	      </xsl:if>
		<xsl:if test="@status='Preparing'">	
		<div class="progress_container" id="progress_container">
		<div class="progress" style="width:0%">
		  <xsl:attribute name="id">progress<xsl:value-of select="@dl_id"/></xsl:attribute>
		</div></div>
		<div style="font-size:11px">
		  <xsl:attribute name="id">fcount<xsl:value-of select="@dl_id"/></xsl:attribute>
		</div>
	      </xsl:if>
	    </td>	
	    <td>
	    <div class="buttoncontainer">
	      <table cellspacing="0" cellpadding="0"><tr>
		<td><div class="previewimg" title="Show graph" style="cursor:pointer">
		  <xsl:attribute name="onclick">javascrip:tooltip.Show(event,'<xsl:value-of select="@dl_id"/>')</xsl:attribute>
		</div></td>
		<td><div class="infoimg" title="Show details" style="cursor:pointer">
		  <xsl:attribute name="onclick">javascript:tooltipdet.Show(event,'<xsl:value-of select="@dl_id"/>', 'true')</xsl:attribute>
		</div></td>
		<td><div class="downloadimg" title="Download file" style="cursor:pointer">
		  <xsl:if test="@status='Ready'">
		    <xsl:attribute name="onclick">javascript:data_export.StartDownload('<xsl:value-of select="@dl_id"/>','<xsl:value-of select="@format"/>','<xsl:value-of select="@dl_name"/>','<xsl:value-of select="@ctype"/>')</xsl:attribute>
		  </xsl:if>
		</div></td>
		<td><div class="deleteimg" title="Delete download" style="cursor:pointer">
		  <xsl:attribute name="onclick">javascript:dlmanager.RemoveDownload('<xsl:value-of select="@dl_id"/>')</xsl:attribute>	
		</div></td>
	      </tr></table>
	     <div title="Uncheck to prevent deleting download automatically when unused">
	    <xsl:attribute name="onmouseover">javascript:showText('auto_delete<xsl:value-of select="@dl_id"/>')</xsl:attribute>
	    <xsl:attribute name="onmouseout">javascript:clearText('auto_delete<xsl:value-of select="@dl_id"/>')</xsl:attribute>
	      <div style="float:right; margin-right:1px; width:20px">		
		<input type="checkbox">
		<xsl:attribute name="name">auto_delete_cb<xsl:value-of select="@dl_id"/></xsl:attribute>
		<xsl:if test="@auto_delete='true'">
		  <xsl:attribute name="checked"></xsl:attribute>
		</xsl:if>		
		<xsl:attribute name="onclick">javascript:dlmanager.ToggleAutodelete('<xsl:value-of select="@dl_id"/>')</xsl:attribute>
		</input>
	      </div>
	      <div style="/*float:left;*/ text-align:left;">
		<xsl:attribute name="id">auto_delete<xsl:value-of select="@dl_id"/></xsl:attribute>		       
	      </div>
	    </div>		
	    </div>
	    </td>
	   </tr>  
	  </xsl:if>	
      </xsl:for-each>     
    </table>    
    <script type="text/javascript">      
	dlmanagerstart();
	showText = function(id){
	  document.getElementById(id).innerHTML="Auto delete";
	}
	clearText = function(id){
	  document.getElementById(id).innerHTML="";
	}	
    </script>
  </div>
  </xsl:template> 
</xsl:stylesheet>
