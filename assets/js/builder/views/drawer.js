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
		},

		onShow: function() {
			this.header.show( new drawerHeaderView() );

			var stagingCollection = nfRadio.channel( 'drawer' ).request( 'get:stagedFields' );
			this.staging.show( new drawerStagingView( { collection: stagingCollection } ) );

			var savedCollection = nfRadio.channel( 'drawer' ).request( 'get:savedFields' );
			this.primary.show( new fieldTypeSectionCollectionView( { collection: savedCollection } ) );
			
			var fieldTypeSectionCollection = nfRadio.channel( 'drawer' ).request( 'get:fieldTypeSections' );
			this.secondary.show( new fieldTypeSectionCollectionView( { collection: fieldTypeSectionCollection } ) );
		
		    jQuery( this.el ).parent().perfectScrollbar();

		    jQuery( this.el ).parent().disableSelection();
		},

		getEl: function() {
			return jQuery( this.el ).parent();
		},

		filterFieldTypes: function( filteredSectionCollection ) {
			this.primary.reset();
			this.secondary.reset();
			this.primary.show( new fieldTypeSectionCollectionView( { collection: filteredSectionCollection } ) );
		},

		removeFieldTypeFilter: function () {
			var savedCollection = nfRadio.channel( 'drawer' ).request( 'get:savedFields' );
			this.primary.show( new fieldTypeSectionCollectionView( { collection: savedCollection } ) );
			
			var fieldTypeSectionCollection = nfRadio.channel( 'drawer' ).request( 'get:fieldTypeSections' );
			this.secondary.show( new fieldTypeSectionCollectionView( { collection: fieldTypeSectionCollection } ) );
		
		}

	} );

	return view;
} );