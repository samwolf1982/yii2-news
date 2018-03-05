
var snapgetTreeViewWrap = function (options) {

    var settings = $.extend({
        rootItemClass: '.root-item',
        treeContainerClass: '.kv-tree-container',
        beforeselectEvent: 'treeview.beforeselect',
        focussedClassName: 'kv-focussed',
        selectedClass: '.kv-selected',
        treeListClass: '.kv-tree-list',
        nodeDetailClass: '.kv-node-detail'
    }, options);

    checkOptions(settings);
    init();

    function checkOptions(settings) {
        if (!settings.frontendCategories || !settings.baseUrl) {
            throw new Error("Options 'frontendCategories', 'baseUrl' are required in 'snapgetTreeViewWrap'");
        }
    }

    function init() {
        $('#' + settings.frontendCategories).on('treeview.beforeselect', function(event, key, jqXHR) {
            window.location.href = settings.baseUrl + '/?id=' + key;
        });

        $(settings.rootItemClass).click(function() {
            window.location.href = settings.baseUrl;
        });

        var $treeContainer = $(settings.treeContainerClass);
        $treeContainer.find('.' + settings.focussedClassName).removeClass(settings.focussedClassName);
        $treeContainer
            .find(settings.selectedClass + ' > ' + settings.treeListClass + ' > ' + settings.nodeDetailClass)
            .addClass(settings.focussedClassName);
    }
};