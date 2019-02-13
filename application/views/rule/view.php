<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title"><?php if($title){ echo $title; } ?></h3>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-md-9">
						<div class="form-group">
							<select class="form-control" id="skema-select">
								<?php
								echo "<option value='0' selected>--Pilih Skema SKKNI--</option>";
								foreach ($result as $value) {
									printf("<option value='%s'>%s</option>", $value->id_skema, $value->id_skema.' - '.$value->nama_skema);
								}
								?>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<a href="#" class="btn btn-primary saveRelasi">Simpan</a>
						</div>
					</div>
				</div>
				<div id="wait" style="display:none">Tunggu Beberapa saat</div>
				<div class="sideBySide row"></div>
			</div>
		</div>
	</div>
</div>
<style type="text/css">
	ul.source, ul.target {
  	min-height: 50px;	margin: 0px 25px 10px 0px; padding: 2px; border-width: 1px;	border-style: solid;
  	-webkit-border-radius: 3px;	-moz-border-radius: 3px; border-radius: 3px; list-style-type: none;
  	list-style-position: inside;
  }
  ul.source { border-color: #f8e0b1; }
  ul.target {	border-color: #add38d; }
  .source li, .target li {
		margin: 5px; padding: 5px;	-webkit-border-radius: 4px; -moz-border-radius: 4px;
		border-radius: 4px; text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
  }
  .source li { background-color: #fcf8e3; border: 1px solid #fbeed5; color: #c09853; }
  .target li { background-color: #ebf5e6;	border: 1px solid #d6e9c6; color: #468847; }
  .sortable-dragging { border-color: #ccc !important; background-color: #fafafa !important;	color: #bbb !important; }
  .sortable-placeholder { height: 40px; }
  .source .sortable-placeholder {	border: 2px dashed #f8e0b1 !important; background-color: #fefcf5 !important; }
  .target .sortable-placeholder {	border: 2px dashed #add38d !important; background-color: #f6fbf4 !important; }
</style>
