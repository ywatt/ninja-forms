define( ['builder/views/drawerFieldTypeSettingGroup'], function( fieldTypeSettingGroupView ) {
	var view = Marionette.CollectionView.extend( {
		tagName: 'div',
		childView: fieldTypeSettingGroupView,

		initialize: function( data ) {
			this.childViewOptions = { fieldModel: data.fieldModel };
		}
	} );

	return view;
} );