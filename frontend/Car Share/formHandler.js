// formHandler.js
class FormHandler {
  static async handleSubmit(event, collectionName) {
    event.preventDefault();
    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData.entries());
    
    try {
      await DatabaseManager.addDocument(collectionName, data);
      this.resetForm(event.target);
      this.showSuccessMessage();
    } catch (error) {
      this.showErrorMessage(error);
    }
  }

  static resetForm(form) {
    form.reset();
  }

  static showSuccessMessage() {
    // Implement UI feedback for successful submission
  }

  static showErrorMessage(error) {
    // Implement error handling and UI feedback
  }
}

export default FormHandler;