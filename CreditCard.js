function showCardInfoPrompt() {
  var cardNumber = prompt("Please enter your card number:");
  var cardHolderName = prompt("Please enter the cardholder's name:");
  var expiryDate = prompt("Please enter the expiry date (YYYY-MM):");

  // Send card information to the server for processing using jQuery.ajax
  $.ajax({
    type: "POST",
    url: "/path/to/save_card_info.php", // Replace with the correct path
    data: {
      cardNumber: cardNumber,
      cardHolderName: cardHolderName,
      expiryDate: expiryDate,
    },
    success: function (data) {
      alert("Successfully added card information");
      // Handle success response if needed
    },
    error: function (error) {
      console.error("Error:", error);
      // Handle error if needed
    },
  });
}
