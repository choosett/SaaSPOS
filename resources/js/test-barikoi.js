import { setConfig, autocomplete } from "barikoiapis";

// Configure Barikoi API
setConfig({
    apiKey: "MjI4NzpXNTY1TTNNM0NR", // Replace with your actual API Key
    version: "v1",
});

// Function to test autocomplete
async function testAutocomplete(query) {
    try {
        const response = await autocomplete({ q: query });
        console.log("Autocomplete Results:", JSON.stringify(response, null, 2));
    } catch (error) {
        console.error("Autocomplete Error:", error);
    }
}

// Run test
testAutocomplete("Gulshan");
