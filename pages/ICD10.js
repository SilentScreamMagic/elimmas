const NLM_API_BASE = 'https://clinicaltables.nlm.nih.gov/api/icd10cm/v3/search';

$(document).ready(function() {
    $('#icdSearchSelect').select2({
        minimumInputLength: 3, // Only search after 3 characters are typed
        placeholder: 'Start typing to search ICD-10...',
        allowClear: true,
        
        // --- Select2 AJAX Configuration ---
        ajax: {
            url: NLM_API_BASE,
            dataType: 'json',
            delay: 250, // Wait 250ms after typing stops before searching (debounce)
            
            // This function creates the API URL parameters
            data: function (params) {
                // 'params.term' is the text the user typed
                return {
                    terms: params.term, // The search term
                    sf: 'code,name',    // Search fields: code and description
                    maxList: 50         // Limit the results displayed
                };
            },
            
            // This function processes the data returned by the NLM API
            processResults: function (data) {
                // The NLM API returns data in a complex array format: 
                // [total_results, [codes], [extra_data], [display_fields], [code_systems]]
                const displayFields = data[3] || []; // Get the array of [code, name] pairs
                
                const results = displayFields.map(function(item) {
                    const [code, description] = item;
                    return {
                        id: `${code} - ${description}`,                     // The actual value to save (e.g., A15.0)
                        text: `${code} - ${description}` // The text displayed to the user
                    };
                });

                return {
                    results: results
                };
            },
            
            cache: true // Cache results for faster searches
        }
    });
    
    // Optional: Add a listener for when a code is actually selected
    $('#icdSearchSelect').on('select2:select', function (e) {
        const data = e.params.data;
        console.log(`ICD-10 Code Selected: ${data.id}`);
        console.log(`Description: ${data.text}`);
        // Now you can send data.id to your server/database for storage
    });
});