<script>
    var product_names = new Bloodhound({
        datumTokenizer: function (d) {
            return Bloodhound.tokenizers.whitespace(d.content)
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: "{{ url('products/search') }}",

            replace: function(url, query) {
                return url + "?q=" + query;
            }
        }
    });

    // Initialise Bloodhound suggestion engines for each input
    product_names.initialize();

    // Make the code less verbose by creating variables for the following
    var productNameTypeahead = $('#product_name.typeahead');
    var productIdTypeahead = $('#product_id.typeahead');

    // Initialise typeahead for the employee name
    productNameTypeahead.typeahead({
        highlight: true
    }, {
        name: 'product_name',
        displayKey: 'content',
        source: product_names.ttAdapter()
    });

    var productNameSelectedHandler = function (eventObject, suggestionObject, suggestionDataset) {
        productIdTypeahead.val(suggestionObject.id);
    };


    // Associate the typeahead:selected event with the bespoke handler
    productNameTypeahead.on('typeahead:selected', productNameSelectedHandler);

</script>