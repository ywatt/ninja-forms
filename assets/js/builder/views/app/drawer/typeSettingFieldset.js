define( ['views/app/drawer/itemSetting'], function( itemSettingView ) {
	var view = Marionette.CompositeView.extend( {
		template: '#nf-tmpl-edit-setting-wrap',
		childView: itemSettingView,

		initialize: function( data ) {
			this.collection = this.model.get( 'settings' );
			this.childViewOptions = { dataModel: data.dataModel };
			this.dataModel = data.dataModel;

			var deps = this.model.get( 'deps' );
			if ( deps ) {
				for ( var name in deps ) {
				    if ( deps.hasOwnProperty( name ) ) {
				    	this.dataModel.on( 'change:' + name, this.render, this );
				    }
				}
			}
		},

		onBeforeDestroy: function() {
			var deps = this.model.get( 'deps' );
			if ( deps ) {
				for (var name in deps) {
				    if ( deps.hasOwnProperty( name ) ) {
				    	this.dataModel.off( 'change:' + name, this.render );
				    }
				}
			}
		},

		onRender: function() {
			// this.$el = this.$el.children();
			// this.$el.unwrap();
			// this.setElement( this.$el );

			// this.$el = this.$el.children();
			// this.$el.unwrap();
			// this.setElement( this.$el );
		},

		templateHelpers: function () {
			var that = this;
	    	return {
	    		renderVisible: function() {
					if ( this.deps ) {
						for (var name in this.deps) {
						    if ( this.deps.hasOwnProperty( name ) ) {
						        if ( that.dataModel.get( name ) !== this.deps[ name ] ) {
						        	return 'style="display:none;"';
						        }
						    }
						}
					}
	    			return '';
	    		},
	    		renderSetting: function(){
					return _.template( jQuery( '#nf-tmpl-edit-setting-' + this.type ).html(), this );
				},
				
				renderWidth: function() {
					if ( 'undefined' != typeof this.width ) {
						return this.width;
					} else {
						return 'one-half';
					}
				}
			}
		},

		attachHtml: function( collectionView, childView ) {
			jQuery( collectionView.el ).find( '.nf-field-sub-settings' ).append( childView.el );
		}

	} );

	return view;
} );