define( ['builder/views/drawerStaging', 'builder/models/stagingCollection', 'builder/views/fieldTypeSectionCollection', 'builder/views/drawerHeader', 'builder/models/fieldTypeCollection'], function( drawerStagingView, StagingCollection, fieldTypeSectionCollectionView, drawerHeaderView, fieldTypeCollection ) {

	var view = Marionette.LayoutView.extend( {
		template: '#nf-tmpl-drawer',

		regions: {
			header: '#nf-drawer-header',
			staging: '#nf-drawer-staging .nf-reservoir',
			primary: '#nf-drawer-primary',
			secondary: '#nf-drawer-secondary'
		},

		initialize: function() {
			nfRadio.channel( 'drawer' ).reply( 'get:drawerEl', this.getEl, this );
			this.listenTo( nfRadio.channel( 'drawer' ), 'filter:fieldTypes', this.filterFieldTypes );
			this.listenTo( nfRadio.channel( 'drawer' ), 'remove:fieldTypeFilter', this.removeFieldTypeFilter );
			this.listenTo( nfRadio.channel( 'drawer' ), 'focus:firstFieldType', this.focusFirstFieldType );
		
			this.savedCollection = nfRadio.channel( 'drawer' ).request( 'get:savedFields' );
			this.primaryCollection = this.savedCollection;

			this.fieldTypeSectionCollection = nfRadio.channel( 'drawer' ).request( 'get:fieldTypeSections' );
			this.secondaryCollection = this.fieldTypeSectionCollection;

		},

		onShow: function() {
			this.header.show( new drawerHeaderView() );

			var stagingCollection = nfRadio.channel( 'drawer' ).request( 'get:stagedFields' );
			this.staging.show( new drawerStagingView( { collection: stagingCollection } ) );

			this.primary.show( new fieldTypeSectionCollectionView( { collection: this.primaryCollection } ) );
			this.secondary.show( new fieldTypeSectionCollectionView( { collection: this.secondaryCollection } ) );

		    jQuery( this.el ).parent().perfectScrollbar();
		    jQuery( this.el ).parent().disableSelection();
		},

		getEl: function() {
			return jQuery( this.el ).parent();
		},

		filterFieldTypes: function( filteredSectionCollection ) {
			this.primary.reset();
			this.secondary.reset();
			this.filteredSectionCollection = filteredSectionCollection;
			this.primary.show( new fieldTypeSectionCollectionView( { collection: this.filteredSectionCollection } ) );
		},

		removeFieldTypeFilter: function () {
			this.primary.show( new fieldTypeSectionCollectionView( { collection: this.savedCollection } ) );
			this.secondary.show( new fieldTypeSectionCollectionView( { collection: this.fieldTypeSectionCollection } ) );
		}

	} );

	return view;
} );