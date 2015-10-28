define( ['builder/views/drawerFieldTypeSetting', 'builder/views/drawerFieldTypeSettingComposite'], function( fieldTypeSettingView, fieldTypeSettingCompositeView ) {
	var view = Marionette.CollectionView.extend( {
		tagName: 'div',
		childView: fieldTypeSettingView,

		initialize: function( data ) {
			this.childViewOptions = { fieldModel: data.fieldModel };
		},

		getChildView: function( model ) {
			if ( model.get( 'settings' ) ) {
				return fieldTypeSettingCompositeView;
			} else if ( model.get( 'childView' ) ) {
				return model.get( 'childView' );
			} else {
				return fieldTypeSettingView;
			}
		}

	} );

	return view;
} );