
<template id="DataImport">
	<div class="dataimport niceupload">
		<div v-show="$refs.upload && $refs.upload.dropActive" v-if="drop" class="drop-active">
			<h3>Drop files to import data</h3>
		</div>
		<file-upload
			  class=""
			  :post-action="postAction"
			  :put-action="putAction"
			  :extensions="extensions"
			  :accept="accept"
			  :multiple="multiple"
			  :maximum="maximum"
			  :directory="directory"
			  :size="size"
			  :thread="thread"
			  :headers="headers"
			  :data="postData"
			  :drop="drop"
			  :drop-directory="dropDirectory"
			  :add-index="addIndex"
			  v-model="files"
			  @input-file="inputFile"
			  ref="upload">
			  <label class="btn btn-sm btn-primary" :for="name"><i class="material-icons">insert_drive_file</i> {{buttontext}}</label>
		</file-upload>
		<div class="upload-panel animated bounceInUp card" v-if="files.length">
			<div v-for="(file, index) in files" :key="file.id">
				<div class="filename">
					{{file.name}}  <small class="text-muted">({{bytesToSize(file.size)}})</small>
				</div>
				<div class="progress" v-if="file.active || file.progress !== '0.00'">
					<div :class="{'progress-bar': true, 'progress-bar-striped': true, 'bg-danger': file.error, 'progress-bar-animated': file.active}" role="progressbar" :style="{width: file.progress + '%'}">{{file.progress}}%</div>
				</div>
				<div>
					<span class="form-text text-danger" v-if="file.error">File {{file.error}} error</span>
					<span  class="form-text text-success" v-else-if="file.success">Success</span>
					<span  class="form-text text-info" v-else-if="file.active">Uploading</span>
					
				</div>
				<div class="py-2 text-muted animated bounceIn" v-if="uploadMsg" v-html="uploadMsg"></div>
				<div class="p-2 text-right">
					<button @click="closePanel()" class="btn btn-sm btn-outline-primary">&times; Close</button>
				</div>
			</div>
		</div>
	</div>
</template>

<template id="HtmlEditor">
   <textarea class='form-control' :name='name'></textarea>
</template>

<template id="NiceFormWizard">
	<form-wizard ref="wizard" :shape="shape" :color="color" :step-size="stepsize">
		<template slot="title">
			<slot name="header"></slot>
		</template>
		<slot></slot>
		<div class="py-2 text-center" slot="footer">
			<clip-loader :loading="saving" size="20px"></clip-loader> 
		</div>
	</form-wizard>
</template>


<template id="WizardBtn">
	<button @click="moveNext()" class="btn btn-primary">{{text}} <span v-html="icon"></span></button>				
</template>

<template id="OptionList">
	<optgroup>
		<option v-for="opt in options" :value="opt.value">{{ opt.label }}</option>
	</optgroup>
</template>


<template id="NiceImg">
	<span>
		<template v-for="(src,index) in arrSrc">
			<router-link v-if="link" :to="link">
				<img @error="imgOnError" :width="width" :height="width" :src="setResizeSrc(src)" :class="imgclass" />
			</router-link>
			<a v-else @click.prevent="openGallery(index)" :href="setPreviewSize(src)">
				<img @error="imgOnError" :width="width" :height="width" :src="setResizeSrc(src)" :class="imgclass" />
			</a>
		</template>
	</span>
</template>

<template id="NiceCarousel">
	<div v-show="show" @click="show = false" @keydown.esc="show = false" class="nicegallery animated fadeIn">
		<div class="container">
			<div class="position-relative holder">
				<div class="img-container text-center">
					<b-carousel 
						id="carousel1" 
						:controls="showControls" 
						:indicators="showControls"
						:interval="0"
						:img-width="width"
						:img-height="height"
						v-model="startIndex"
					>
						<b-carousel-slide :key="index" v-for="(src,index) in arrSrc">
							<img slot="img" class="img-fluid" :src="setResizeSrc(src)">
						</b-carousel-slide>
					</b-carousel>
				</div>
				<button @click="show = false" class="close-btn btn btn-light"><i class="material-icons">close</i></button>
			</div>
			
		</div>
	</div>
</template>


<template id="DataSelect">
	<div class="data-select">
		<select v-model="selected" :multiple="multiple" class="custom-select form-control">
			<option v-if="placeholder" value="">{{ placeholder }}</option>
			<option v-for="opt in options" v-if="opt.value != undefined" :value="opt.value">{{ opt.label }}</option>
			<option v-for="opt in options" v-if="opt.value == undefined">{{ opt }}</option>
		</select>
		<span class="load-indicator" v-if="loading"><clip-loader :loading="loading" size="20px"></clip-loader> </span>
	</div>
</template>

<template id="DataVSelect">
	<div class="data-select">
		<v-select @search="onSearch" v-model="selected" :options="options" taggable push-tags :placeholder="placeholder" :disabled="disabled" :multiple="multiple" :limit="limit"
		>
		</v-select>
		<span class="load-indicator" v-if="loading"><clip-loader :loading="loading" size="20px"></clip-loader> </span>
	</div>
</template>


<template id="DataCheck">
	<div class="data-select">
		<span class="load-indicator" v-if="loading"><clip-loader :loading="loading" size="20px"></clip-loader> </span>
		<template v-if="isbutton" >
		  <b-form-checkbox-group text-field="label" style="width: 100%" v-model="selected"
								 buttons
								 :stacked="btnvertical"
								 :button-variant="btnvariant"
								 name="buttons2"
								 :options="options">
		  </b-form-checkbox-group>
		</template>
		<template v-else v-for="opt in options">
			<label :class="checkclass" v-if="opt.value || opt.label">
				<input type="checkbox" v-model="selected" :value="opt.value">
				{{ opt.label }}
			</label>

			<label :class="checkclass" v-else>
				<input type="checkbox" v-model="selected" :value="opt" />
				{{ opt }}
			</label>
		</template>
	</div>
</template>


<template id="DataRadio">
	<div class="data-select">
		<span class="load-indicator" v-if="loading"><clip-loader :loading="loading" size="20px"></clip-loader> </span>
		<template v-if="isbutton" >
			  <b-form-radio-group text-field="label" class="d-block" v-model="selected"
									buttons
									:button-variant="btnvariant"
									:stacked="btnvertical"
									name="buttons2"
									:options="options">
			  </b-form-radio-group>
		</template>
		<template v-else v-for="opt in options">
			<label :class="checkclass" v-if="opt.value || opt.label">
				<input type="radio" v-model="selected" name="optionname" :value="opt.value" />
				{{ opt.label }}
			</label>
			<label :class="checkclass" v-else>
				<input type="radio" v-model="selected" name="optionname" :value="opt" />
				{{ opt }}
			</label> 
		</template>
	</div>
</template>

<template id="NiceToggle">
	<div class="niceswitch">
		<label class="switch"> 
			<input v-model="checked" type="checkbox" name="switchbox" /> 
			<span class="slider" :class="setBgColor"></span>
		</label>
		<span class="label animated zoomIn" v-if="!checked">{{textDisabled}}</span>
		<span class="label animated zoomIn" v-if="checked">{{textEnabled}}</span>
	</div>
</template>

<template id="NiceChart">
	<canvas :width="width" :height="height" ref="canvas" id="canvas"></canvas>
</template>

<template id="NiceUpload">
	<div :id="fieldname" class="niceupload" v-bind:class="{ 'active': $refs.upload && $refs.upload.dropActive }">
		<file-upload
			:class="controlClass"
			:post-action="postAction"
			:put-action="putAction"
			:extensions="extensions"
			:accept="accept"
			:multiple="multiple"
			:maximum="maximum"
			:directory="directory"
			:size="size"
			:thread="thread"
			:headers="headers"
			:data="data"
			:drop="'#' + fieldname"
			:drop-directory="dropDirectory"
			:add-index="addIndex"
			:input-id="fieldname"
			v-model="files"
			@input-filter="inputFilter"
			@input-file="inputFile"
			ref="upload">
			<div  v-if="drop && dropmsg" class="drop-msg">
				{{dropmsg}} 
				<span class="btn btn-primary">{{buttontext}}</span>
			</div>
		</file-upload>
		
		<div v-if="files.length" class="upload mt-2">
			<div class="table-responsive">
				<table class="table table-hover">
					<tbody>
						<tr v-for="(file, index) in files" :key="file.id">
							<td>
								<img v-if="file.thumb" :src="file.thumb" class="thumb-img" />
								<span v-else>No Image</span>
							</td>
							<td>
								<div class="filename">
									{{file.name}}  <small class="text-muted">({{bytesToSize(file.size)}})</small>
								</div>
								<div class="progress" v-if="file.active || file.progress !== '0.00'">
									<div :class="{'progress-bar': true, 'progress-bar-striped': true, 'bg-danger': file.error, 'progress-bar-animated': file.active}" role="progressbar" :style="{width: file.progress + '%'}">{{file.progress}}%</div>
								</div>
								<div>
									<span class="form-text text-danger" v-if="file.error">File {{file.error}} error</span>
									<span  class="form-text text-success" v-else-if="file.success">Success</span>
									<span  class="form-text text-info" v-else-if="file.active">Uploading</span>
									
								</div>
							</td>
							<td>
								<button type="button" class="btn btn-default btn-sm" @click="removeFile(file,index)">&times;</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div v-if="uploadedData.length>0" class="file-list mt-1">
			<span class="text-bold">Uploaded Files</span>
			<template v-for="(url,index) in uploadedData" v-if="url">
				<a class="btn btn-outline-primary btn-sm" v-if="url" target="_blank" :href="url">
					{{getFileName(url)}}
				</a>
				<button type="button" @click="removeUpload(index)" class="btn btn-sm">&times;</button>
			</template>
		</div>
	</div>
</template>

<template id="NiceMenu">
	<ul :class="setmenuclass">
		<template  v-for="menu in menus">
			<router-link v-if="!menu.submenu  || !menu.submenu.length" class="nav-link" :to="'/' + menu.path">
				<span v-if="menu.icon" v-html="menu.icon"></span>
				{{menu.label}}
			</router-link>
			<li class="dropdown-submenu" v-else>
				<a href="#" @click.prevent="noClick()" class="dropdown-toggle" data-toggle="dropdown">
					<span v-if="menu.icon" v-html="menu.icon"></span>
					{{menu.label}}
				</a>
				<nicemenu :submenu="true" :menus="menu.submenu"></nicemenu>	
			</li>
		</template>
	</ul>
</template>

<template id="DataMenu">
	<div>
		<div v-if="title" class="p-2">
			<div class="row">
				<div class="col">
					<h5>{{title}}</h5>
				</div>
				<div v-if="responsive" class="col-3 text-right">
					<span class="d-block d-sm-none"><button @click="toggleCollaps" class="btn btn-light btn-sm"><i class="material-icons">arrow_drop_down</i></button></span>
				</div>
			</div>
		</div>
		<div v-if="!title && responsive" class="text-right d-block d-sm-none">
			<button @click="toggleCollaps" class="btn btn-light btn-sm"><i class="material-icons">arrow_drop_down</i></button>
		</div>
		<div :class="setCollapseClass">
			<ul :class="menuclass">
				<template  v-for="menu in menus">
					<router-link class="nav-link" :to="setMenuLink(menu)">
						<span v-if="menu.icon" v-html="menu.icon"></span>
						{{ setMenuLabel(menu) }}
						<span v-if="menu.num" class="badge badge-pill badge-secondary">{{menu.num}}</span>
					</router-link>
				</template>
			</ul>
		</div>
		<span class="load-indicator" v-if="loading"><clip-loader :loading="loading" size="20px"></clip-loader> </span>
	</div>
</template>
<template id="DataDropMenu">
	<b-dropdown :variant="variant" :size="size">
		<span slot="button-content">
			<span class="load-indicator" v-if="loading"><clip-loader :loading="loading" size="15px"></clip-loader> </span>
			<slot></slot>
		</span>
		<b-dropdown-item v-if="defaultitem" :active="setActiveMenu('')" @click="filter('')" >
			<span class="text-muted" v-html="defaultitem"></span>
		</b-dropdown-item>
		<b-dropdown-item :active="setActiveMenu(menu)" @click="filter(menu)" v-for="menu in menus">
			<span v-if="menu.icon" v-html="menu.icon"></span>
			{{ setMenuLabel(menu) }}
			<span v-if="menu.num" class="badge badge-pill badge-secondary">{{menu.num}}</span>
		</b-dropdown-item>
	</b-dropdown>
</template>
<template id="DataNavMenu">
	<div>
		<span class="load-indicator" v-if="loading"><clip-loader :loading="loading" size="20px"></clip-loader> </span>
		<b-nav :pills="pill" :tabs="tab" :fill="fill" :justified="justify" :vertical="vertical" >
			<b-nav-item v-if="defaultitem" :active="setActiveMenu('')" @click="filter('')" >
				<span class="text-muted" v-html="defaultitem"></span>
			</b-nav-item>
			<b-nav-item :active="setActiveMenu(menu)" @click="filter(menu)" v-for="menu in menus">
				<span v-if="menu.icon" v-html="menu.icon"></span>
				{{ setMenuLabel(menu) }}
				<span v-if="menu.num" class="badge badge-pill badge-secondary">{{menu.num}}</span>
			</b-nav-item>
		</b-nav>
	</div>
</template>
<template id="RecordCount">
	<div @click="navigate()" class="animated record-count" :class="setCssStyle">
		<div class="row">
			<div class="col-3">
				<div class="icon" v-html="icon"></div>
			</div>
			<div class="col-9">
				<div class="flex-column justify-content align-center">
					<div class="title">{{title}}</div>
					<b-progress v-if="progressmax > 0" height="5px" :value="recordcount" :variant="variant" :max="progressmax"></b-progress>
					<small class="small desc">{{desc}}</small>
				</div>
			</div>
			<h4 class="value"><strong>{{prefix}}{{recordcount}}{{suffix}} </strong></h4>
		</div>
		
	</div>
</template>
<template id="RecordProgress">
	<div v-if="layout == 'flex'" @click="navigate()" class="animated record-progress" :class="setCssStyle">
		<div class="icon" v-html="icon"></div>
		<div class="row">
			<div class="col-3">
				<radialprogress v-if="progressmax > 0" :diameter="diameter" :completed-steps="recordcount" :total-steps="progressmax" :start-color="setStartColor" :stop-color="setStopColor">
					<h5>{{prefix}}{{recordcount}}{{suffix}}</h5>
				</radialprogress>
			</div>
			<div class="col-9">
				<div class="title">{{title}}</div>
				<small class="small desc">{{desc}}</small>
			</div>
		</div>
	</div>
	
	<div v-else @click="navigate()" class="animated record-progress" :class="setCssStyle">
		<div class="icon" v-html="icon"></div>
		<div class="title">{{title}}</div>
		<radialprogress v-if="progressmax > 0" :diameter="diameter" :start-color="setStartColor" :stop-color="setStopColor" :completed-steps="recordcount" :total-steps="progressmax">
			<h5>{{prefix}}{{recordcount}}{{suffix}}</h5>
		</radialprogress>
		<small class="small desc text-center">{{desc}}</small>
	</div>
	
</template>
<template id="ThSort">
	<a href="" @click.prevent="sort()">
		{{title}}
		<span v-if="currentorderby == fieldname" class="icon">
			<i v-if="currentordertype=='asc'"><i class="material-icons">arrow_drop_down</i></i>
			<i v-if="currentordertype=='desc'"><i class="material-icons">arrow_drop_up</i></i>
		</span>
		<span  class="icon" v-else><i class="material-icons">sort</i></span>
	</a>
</template>
<template id="Pagination">
	<div>
		<div class="row">
			<div v-if="showRecordCount" class="col align-self-center">
				<label> 记录  : {{recordPosition}}  的  {{totalItems}}</label>
			</div>
			
			<div v-if="showPageCount" class="col align-self-center">
				<label>
					页 :
					<select v-model="currentpage" style="display:inline-block;width:50px" class="custom form-control form-control-sm">
						<option v-for="n in (1,totalPages)">{{n}}</option>
					</select> 
					 的 {{totalPages}}
				</label>
			</div>
			
			<div v-if="showPageLimit" class="col align-self-center">
				<label>限制  : <input @change="limitChanged" v-model="pageLimit" type="number" step="1" min="0" :max="totalPages" class="form-control form-control-sm" style="display:inline-block;width:50px" /> </label>
			</div>
			
			<div class="col-sm-4 align-self-center">
				<b-pagination class="my-auto" size="sm" :limit="offset" :first-text="firstText" :last-text="lastText" :next-text="nextText" :prev-text="prevText" align="center" :total-rows="totalItems" v-model="currentpage" @input="pageChanged" :per-page="pageLimit"></b-pagination>
			</div>
		</div>
	</div>
</template>
<template id="RadialProgress">
  <div class="radial-progress-container" :style="containerStyle">
    <div class="radial-progress-inner" :style="innerCircleStyle">
      <slot></slot>
    </div>
    <svg class="radial-progress-bar"
         :width="diameter"
         :height="diameter"
         version="1.1"
         xmlns="http://www.w3.org/2000/svg">
      <defs>
        <radialGradient :id="'radial-gradient' + _uid"
                        :fx="gradient.fx"
                        :fy="gradient.fy"
                        :cx="gradient.cx"
                        :cy="gradient.cy"
                        :r="gradient.r">
          <stop offset="30%" :stop-color="startColor"></stop>
          <stop offset="100%" :stop-color="stopColor"></stop>
        </radialGradient>
      </defs>
      <circle :r="innerCircleRadius"
              :cx="radius"
              :cy="radius"
              fill="transparent"
              :stroke="innerStrokeColor"
              :stroke-dasharray="circumference"
              stroke-dashoffset="0"
              stroke-linecap="round"
              :style="strokeStyle"></circle>
      <circle :transform="'rotate(270, ' + radius + ',' + radius + ')'"
              :r="innerCircleRadius"
              :cx="radius"
              :cy="radius"
              fill="transparent"
              :stroke="'url(#radial-gradient' + _uid + ')'"
              :stroke-dasharray="circumference"
              :stroke-dashoffset="circumference"
              stroke-linecap="round"
              :style="progressStyle"></circle>
    </svg>
  </div>
</template>