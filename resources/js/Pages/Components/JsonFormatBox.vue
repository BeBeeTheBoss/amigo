<template>
    <div class="json-container">
        <textarea v-model="jsonInput" @input="parseJson" placeholder="Enter JSON here..."></textarea>
        <div v-html="formattedJson" class="json-output"></div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            jsonInput: '{}',
            formattedJson: ''
        };
    },
    methods: {
        parseJson() {
            try {
                const json = JSON.parse(this.jsonInput);
                this.formattedJson = this.formatJson(json);
            } catch (e) {
                this.formattedJson = `<span class="error">Invalid JSON</span>`;
            }
        },
        formatJson(json) {
            const jsonString = JSON.stringify(json, null, 2);
            const formatted = jsonString
                .replace(/({|}|\[|\])/g, '<span class="bracket">$1</span>') // Style brackets
                .replace(/"([^"]+)":/g, '<span class="key">"$1":</span>'); // Style values
            return `<pre>${formatted}</pre>`;
        }
    }
};
</script>

<style>
/* Container styling */
.json-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
    max-width: 800px;
    margin: auto;
}

/* Textarea styling */
textarea {
    width: 100%;
    height: 200px;
    font-family: monospace;
    font-size: 16px;
    padding: 10px;
    border: 2px solid #4CAF50;
    border-radius: 8px;
    background-color: #f5f5f5;
    color: #AC603C;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: border-color 0.3s, box-shadow 0.3s;
}

textarea:focus {
    border-color: #0d9deb;
    box-shadow: 0 4px 12px rgba(33, 150, 243, 0.3);
}

/* JSON output container */
.json-output {
    background: #2b2b2b;
    color: #f6ad83;
    border-radius: 8px;
    padding: 20px;
    overflow: auto;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    font-family: 'Fira Code', monospace;
    white-space: pre-wrap;
}

/* JSON key styling */
.key {
    color: #7bbdf3;
    /* Pink */
    font-weight: bold;
}

/* Bracket styling */
.bracket {
    color: white;
    /* Purple */
}

/* Error styling */
.error {
    color: #ff5555;
    /* Red */
    font-weight: bold;
    font-size: 18px;
}
</style>
