var icons = {
    'success': '<span class="dashicons dashicons-yes"></span>',
    'error':   '<span class="dashicons dashicons-no"></span>',
    'loading': '<span class="dashicons dashicons-update"></span>',
};

/*
 |--------------------------------------------------------------------------
 | Upgrade Model
 |--------------------------------------------------------------------------
 */

var Upgrade = Backbone.Model.extend({
    defaults: {
        name: '',
        status: 'loading',
        steps: []
    },
})

var UpgradeItemView = Marionette.ItemView.extend({
    tagName: 'tr',
    template: '#nf-tmpl-table-row',

    initialize: function() {
        this.model.on('change', this.render, this);
    },

    templateHelpers: function() {
        return {
            icon: function() {
                return icons[this.status];
            }
        }
    }
});

var UpgradeItemEmptyView = Marionette.ItemView.extend({
    tagName: 'tr',
    template: '#nf-tmpl-table-row-empty',
});

/*
 |--------------------------------------------------------------------------
 | Upgrades Collection
 |--------------------------------------------------------------------------
 */

var UpgradesCollection = Backbone.Collection.extend({
    model: Upgrade
});


var UpgradesCollectionView = Marionette.CollectionView.extend({
    tagName: 'tbody',
    childView: UpgradeItemView,
    emptyView: UpgradeItemEmptyView
});

/*
 |--------------------------------------------------------------------------
 | Layouts Views
 |--------------------------------------------------------------------------
 */

var AppBeforeView = Marionette.ItemView.extend({
    template: '#nf-tmpl-before'
});

var AppAfterView = Backbone.View.extend({
    initialize: function() {
        this.render();
    },
    render: function() {
        var template = _.template(jQuery('#nf-tmpl-after').html(), {});
        this.$el.html(template);
    },
});

var AppLayoutView = Marionette.LayoutView.extend({
    el: '#app-output',

    template: "#layout-view-template",

    regions: {
        before: '#app-before',
        content: '#app-content',
        after: '#app-after'
    },

    onRender: function() {

        this.before.show(new AppBeforeView());

        this.content.show(new UpgradesCollectionView({
            collection: upgradesCollection
        }));

        this.after.show(new AppAfterView());

        // Pre-pend table headers
        var tableHead = _.template(jQuery('#nf-tmpl-table-head').html(), {});
        jQuery('#app-content').find('tbody').before(tableHead);
    }
});

var upgradesCollection = new UpgradesCollection();

_.each( nf_forms, function( form ){
    upgradesCollection.add(new Upgrade({ name: form.title, form_id: form.id }));
});

var layoutView = new AppLayoutView();
layoutView.render();

/*
 |--------------------------------------------------------------------------
 | Start Upgrades
 |--------------------------------------------------------------------------
 */

upgradesCollection.each( function( upgrade ) {

    var data = {
        action: 'nf_ajax_upgrade',
        form_id: upgrade.get('form_id')
    };

    jQuery.ajax({ type: "post", data: data, url: ajaxurl, success: function ( response ) {

        if( response.data.errors ) {
            upgrade.set( 'status', 'error' );
        } else {
            upgrade.set('status', 'success');
        }

        maybeRedirect();

    }, dataType: 'json', context: this });
});

function maybeRedirect(){

    var redirect = true;

    upgradesCollection.each( function( upgrade ){
        if( 'loading' == upgrade.get( 'status' ) ){
            redirect = false;
        }
    });

    if( redirect ){
        window.location.href = nf_redirect;
    }
}