import time
import os
import re


CHAT_FILE = r"C:\Users\Sergiu\Desktop\Master\chat.txt"
responses = {
    "how to order a product": "To order a product, add it to your cart and proceed to checkout.",
    "how to return a product": "You can return a product within 30 days. Contact us in order to get more information about the retur.",
    "how to contact us": "You can contact us via email at support@furniturestore.com or call us at +123456789.",
    "how to check the stock of our products": "You can check product availability on our website by visiting the product page.",
}

number_to_question = {
    "1": "how to order a product",
    "2": "how to return a product",
    "3": "how to contact us",
    "4": "how to check the stock of our products",
}

def clean_message(message):
    message = message.strip().lower()

    message = re.sub(r"[^a-zA-Z0-9\s]", "", message)
    return message

def chatbot():
    print("Server is running...")

    if not os.path.exists(CHAT_FILE):
        with open(CHAT_FILE, "w") as file:
            file.write("")

    last_read = ""

    while True:
        try:
            with open(CHAT_FILE, "r") as file:
                data = file.read().strip()

            if data and data.startswith("USER:") and data != last_read:
                last_read = data  # Update last read message
                user_message = data.replace("USER:", "").strip()

                cleaned_message = clean_message(user_message)

                if cleaned_message in number_to_question:
                    cleaned_message = number_to_question[cleaned_message]

                if cleaned_message in responses:
                    response = f"BOT: {responses[cleaned_message]}"
                else:
                    response = "BOT: Sorry, I didn't understand. Please ask a listed question or enter 1-4."

                with open(CHAT_FILE, "w") as file:
                    file.write(response)

            time.sleep(1) 
        except Exception as e:
            print(f"Error: {e}")
            time.sleep(1)

if __name__ == "__main__":
    chatbot()
