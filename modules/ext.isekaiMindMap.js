$(function() {
    function simpleHtmlUnescape(text) {
        return text.replace(/&lt;/g, '<').replace(/&gt;/g, '>');
    }

    console.log('show mindMap');
    var mindMapBasePath = mw.config.get("wgScriptPath") + '/extensions/IsekaiMindMap/public/';
    var viewerUrl = `${mindMapBasePath}index.html?viewer=true`;

    var iframeDataList = [];

    window.addEventListener('message', function(event) {
        if (event.origin !== window.location.origin) {
            return;
        }

        var data = event.data;
        if (!data) return;

        switch (data.type) {
            case 'app_loaded':
                console.log('MindMapViewer loaded');
                let currentData = iframeDataList.find(function(iframeData) {
                    return (iframeData.el || {}).contentWindow === event.source;
                });

                if (currentData) {
                    currentData.el.contentWindow.postMessage({
                        type: 'init_set_mind_map_data',
                        data: currentData.data
                    }, '*');
                }
                break;
            case 'app_inited':
                console.log('MindMapEditor initialized');
                break;
        }
    });

    $('script[type="application/x-isekai-mindmap"]').each(function() {
        var $mindMapScript = $(this);
        var $mindMapViewers = $(`<iframe class="isekai-mindMapViewer" frameBorder="0" src="${viewerUrl}"></iframe>`);

        $mindMapViewers.insertAfter($mindMapScript);

        var elMindMapEditor = $mindMapViewers[0];

        iframeDataList.push({
            el: elMindMapEditor,
            data: JSON.parse(simpleHtmlUnescape($mindMapScript.html()))
        });
    });
});