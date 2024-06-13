function copyShortcode() {
    // Get the shortcode text
    var shortcodeText = document.getElementById('shortcode-example').innerText;

    // Create a temporary input element
    var tempInput = document.createElement('input');
    tempInput.value = shortcodeText;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand('copy');
    document.body.removeChild(tempInput);

    // Alert the user
    alert('Shortcode copied to clipboard: ' + shortcodeText);
}
