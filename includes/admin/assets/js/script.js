// progress bar
Vue.component( 'mx_import_complete', {

	props: {
		uploaded_items: {
			type: Array
		},
		file_data: {
			type: Array
		}
	},

	template: `
		<div
			v-if="uploaded_items.length === file_data.length"
			v-show="file_data"
			class="mx-import-compete-wrap"
			style="display: none;"
		>
			<h4 					
				class="mx-imort-compete"
			>Import complete!</h4>

			<p>
				Please refresh the page to import another file.
			</p>
		</div>
	`

} )

// result
Vue.component( 'mx_result_csv_import', {

	props: {
		uploaded_items: {
			type: Array
		},
		import_item_coplete: {
			type: Array
		},
	},

	template: `
		<div>

			<h3>CSV file import result</h3>

			<p>There are {{ uploaded_items.length }} items to import</p>

			<div
				class="mx-csv-content-wrapper mx-import-result"
				id="mx_result_stack"
			>

				<table>

					<tr>
						<th
							v-for="(th, index ) in import_item_coplete[0]"
						>{{ index }}</th>
					</tr>

					<tr
						v-for="row in import_item_coplete"
					>

						<td
							v-for="item in row"							
						>{{ item }}</td>

					</tr>

				</table>

			</div>

		</div>
	`

} )

// progress bar
Vue.component( 'mx_progress_bar', {

	props: {
		progress: {
			type: Boolean
		}
	},

	template: `
		<div class="mx_progress_bar">
			Progress...<br>
			Please do not refresh the page.
		</div>	
	`

} )

// CSV content wrapper
Vue.component( 'mx_csv_content', {

	props: {
		file_data: {
			type: Array,
			required: true
		}
	},

	template: `
		<div>

			<h3>CSV file content</h3>

			<p>There are {{ file_data.length }} items to import</p>

			<button
				@click.prevent="importDataProducts"
				class="mx_button"
			>Confirm data import</button>

			<div
				class="mx-csv-content-wrapper"
				id="mx_result_stack"
			>

				<table>

					<tr>
						<th
							v-for="(th, index ) in file_data[0]"
						>{{ index }}</th>
					</tr>

					<tr
						v-for="row in file_data"
					>

						<td
							v-for="item in row"
							v-html="item"
						></td>

					</tr>

				</table>

			</div>

		</div>
	`,
	data() {
		return {
			interval_soul: null,
			set_interval: true,
			item_index: 0,
			imported_items: []
		}
	},
	methods: {

		importDataProducts() {

			if( confirm( 'Do you really want to insert data to your website?' ) ) {

				this.$emit( 'progress', true )

				let _this = this

				this.interval_soul = setInterval( function() {

					if( _this.file_data.length > _this.item_index ) {

						if( _this.set_interval ) {

							_this.set_interval = false

							let data = {

								'action': 'mxmtzc_insert_data',
								'nonce': mxutwfc_admin_localize.nonce,
								'line': _this.file_data[_this.item_index]

							}

							jQuery.ajax( {

								url: mxutwfc_admin_localize.ajaxurl,
								type: 'POST',
								data: data,
								success: function( response ) {

									_this.$emit( 'uploaded_item', _this.file_data[_this.item_index] )

									let complete = true

									let post_id = response

									if( response === 'failed' ) {

										complete = false

										post_id = null

									}

									_this.$emit( 'import_complete', {
										id: _this.file_data[_this.item_index]['id'],
										post_id: post_id,
										complete: complete										
									} )

									_this.item_index += 1

									_this.set_interval = true
									
								},

								error: function( response ) {

									// console.log( 'error' + response );

								}

							} )

						}

					} else {

						_this.$emit( 'progress', false )

						clearInterval( _this.interval_soul )

					}					

				}, 500 )

			}

		}

	}

} )

// upload CSV file form
Vue.component( 'mx_upload_csv_form', {

	template: `

		<div>

			<div
				v-if="file_abspath && csv_content"
				class="mx_file_url"
			>{{ file_url }}</div>
			<form
				v-if="!file_abspath || !csv_content"
			>

				<button
					@click.prevent="uploadSCV"
					class="mx_button"
				>Upload CSV file</button>

			</form>
		</div>

	`,
	data() {
		return {
			file_id: null,
			file_abspath: null,
			file_url: null,
			csv_content: null
		}
	},
	methods: {
		uploadSCV() {			
			
			let frame;

			let _this = this

			if ( frame ) {
				frame.open()
				return
			}

			frame = wp.media.frames.customBackground = wp.media({

				title: 'choose file',

				// library: {
				// 	type: 'csv'
				// },

				button: {

					text: 'Upload'
				},

				multyple: false
			})

			frame.on( 'select', function() {

				let attachment = frame.state().get('selection').first()

				let file_id = attachment.id

				let file_url = attachment.attributes.url

				_this.$emit( 'progress', true )

				if( ! isNaN( file_id ) ) {

					_this.file_id = file_id

					_this.file_url = file_url

				} else {

					_this.$emit( 'error', 'Getting abspaty error through upload' )

				}

				_this.$emit( 'progress', false )
 
			} )

			frame.open()
		},

		// get file abspath
		getFileAbspath( id ) {

			this.$emit( 'progress', true )

			let _this = this

			let data = {

				'action'	:  'mxmtzc_get_file_abspath',
				'nonce'		: 	mxutwfc_admin_localize.nonce,
				'file_id'	: 	id

			}

			// $.ajax
			jQuery.post( mxutwfc_admin_localize.ajaxurl, data, function( file_abspath ) {

				if( file_abspath !== 'not csv' ) {

					_this.file_abspath = file_abspath

				} else {

					_this.$emit( 'error', 'File type error. Choose CSV file' )

				}

				_this.$emit( 'progress', false )

			} )	

		},

		// get file data
		getFileData( file_abspath ) {

			this.$emit( 'progress', true )

			let _this = this

			let data = {

				'action'		:  'mxmtzc_get_file_data',
				'nonce'			: 	mxutwfc_admin_localize.nonce,
				'file_abspath'	: 	file_abspath

			}

			// $.ajax
			jQuery.post( mxutwfc_admin_localize.ajaxurl, data, function( responce ) {

				if( responce == 'not csv' ) {

					_this.$emit( 'error', 'File type error' )

					_this.file_id 		= null
					_this.file_abspath 	= null
					_this.file_url 		= null

				} else {

					if( _this.isJSON( responce ) ) {

						const regex = /\'/g;

						_this.csv_content = responce.replace( regex, '&apos;' )

						_this.$emit( 'error', false )

					} else {

						_this.$emit( 'error', 'File content error.' )

					}					

				}

				_this.$emit( 'progress', false )

			} )

		},

		isJSON( str ) {
			try {
		        JSON.parse(str);
		    } catch (e) {
		        return false;
		    }
		    return true;
		}
	},
	watch: {
		csv_content() {

			this.$emit( 'csv_content', this.csv_content )

		},
		file_id() {

			this.getFileAbspath( this.file_id )
		},
		file_abspath() {

			this.getFileData( this.file_abspath )

		}
	}
} )

if( document.getElementById( 'mx_optimizer_app' ) ) {

	let app = new Vue( {
		el: '#mx_optimizer_app',
		data: {
			nonce: mxutwfc_admin_localize.nonce,
			ajaxurl: mxutwfc_admin_localize.ajaxurl,
			file_data: null,
			errors: [],
			progress: false,
			uploaded_items: [],
			import_item_coplete: []
		},
		methods: {
			setImportComplete( obj ) {

				this.import_item_coplete.push( obj )

			},
			setUploadedItems( row ) {

				this.uploaded_items.push( row )

			},
			setProgress( bool ) {

				this.progress = bool

			},
			setCSVContent( content ) {

				this.file_data = JSON.parse( content )

			},
			setError( str ) {

				if( str ) {

					this.errors.push( str )

				} else {

					this.errors = []

				}
				
			}
		}

	} )

}