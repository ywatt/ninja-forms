define( [ 'views/fieldCollection','views/afterFields', 'views/beforeFields', 'models/fieldCollection' ], function( fieldCollectionView, afterFields, beforeFields, FieldCollection ) {

	var view = Marionette.LayoutView.extend({
		tagName: "nf-section",
		template: "#nf-tmpl-form-layout",

		regions: {
			beforeFields: ".nf-before-fields",
			fields: ".nf-fields",
			afterFields: ".nf-after-fields"
		},

		initialize: function() {
			nfRadio.channel( 'form-' + this.model.get( 'id' ) ).reply( 'get:el', this.getEl, this );
			/*
			 * Set our default fieldContentsView.
			 */
			nfRadio.channel( 'fieldContents' ).request( 'add:viewFilter', this.defaultFieldContentsView, 10, this );
			/*
			 * Set our default fieldContents load filter
			 */
			nfRadio.channel( 'fieldContents' ).request( 'add:loadFilter', this.defaultFieldContentsLoad, 10, this );
		},

		onRender: function() {
			this.$el = this.$el.children();
			this.$el.unwrap();
			this.setElement( this.$el );
		},

		onShow: function() {
			this.beforeFields.show( new beforeFields( { model: this.model } ) );
			
			/*
			 * Set our fieldContentsData to our form setting 'fieldContentsData'
			 */
			var fieldContentsData = this.model.get( 'fieldContentsData' );

			/*
			 * Check our fieldContentViewsFilter to see if we have any defined.
			 * If we do, overwrite our default with the view returned from the filter.
			 */
			var fieldContentsViewFilters = nfRadio.channel( 'fieldContents' ).request( 'get:viewFilters' );
			
			/* 
			* Get our first filter, this will be the one with the highest priority.
			*/
			var sortedArray = _.without( fieldContentsViewFilters, undefined );
			var callback = _.first( sortedArray );
			fieldContentsView = callback();
			
			var fieldContentsLoadFilters = nfRadio.channel( 'fieldContents' ).request( 'get:loadFilters' );
			/* 
			* Get our first filter, this will be the one with the highest priority.
			*/
			var sortedArray = _.without( fieldContentsLoadFilters, undefined );
			var callback = _.first( sortedArray );
			fieldContentsData = callback( fieldContentsData, this.model, this );
			
			this.fields.show( new fieldContentsView( { collection: fieldContentsData } ) );
			this.afterFields.show( new afterFields( { model: this.model } ) );
		},

		getEl: function() {
			return this.el;
		},

        templateHelpers: function () {
            return {

                renderClasses: function() {
                    return '';
                }

            };
        },

        defaultFieldContentsView: function() {
        	return fieldCollectionView;
        },

        defaultFieldContentsLoad: function( fieldContentsData, formModel, context ) {
        	var fieldModels = _.map( fieldContentsData, function( key ) {
        		return formModel.get( 'fields' ).findWhere( { key: key } );
        	}, this );

        	return new FieldCollection( fieldModels );
        }

	});

	return view;
} );