<div class="mx-main-page-text-wrap">
	
	<h1><?php echo __( 'Import Products', 'mxutwfc-domain' ); ?></h1>

	<div id="mx_optimizer_app">

		<!-- import complete -->
		<mx_import_complete
			v-if="file_data"
			:file_data="file_data"
			:uploaded_items="uploaded_items"
		></mx_import_complete>

		<!-- errors -->
		<ul 
			v-if="errors.length > 0"
			class="mx-error"
		>
			<li v-for="error in errors">
				{{ error }}
			</li>			
		</ul>

		<!-- progress bar -->
		<mx_progress_bar
			v-if="progress"
		></mx_progress_bar>
		
		<!-- form -->
		<mx_upload_csv_form
			@error="setError"
			@csv_content="setCSVContent"
			@progress="setProgress"
			v-show="!progress"
		></mx_upload_csv_form>

		<!-- CSV content -->
		<mx_csv_content
			v-if="file_data"
			:file_data="file_data"
			@progress="setProgress"
			@uploaded_item="setUploadedItems"
			@import_complete="setImportComplete"
			v-show="uploaded_items.length === 0 && !progress"
		></mx_csv_content>

		<!-- Import result -->
		<mx_result_csv_import
			v-if="uploaded_items.length > 0"
			:uploaded_items="uploaded_items"
			:import_item_coplete="import_item_coplete"
		></mx_result_csv_import>

		<!-- Removed post IDS -->
		<mx_removed_posts
			v-if="repoved_post_ids.length > 0"
			:repoved_post_ids="repoved_post_ids"
		></mx_removed_posts>

	</div>

</div>