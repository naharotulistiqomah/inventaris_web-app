import os 
from flask import Flask, request, jsonify
from services.ai_logic import analyze_item
from services.alert_logic import generate_alerts
from services.chatbot_logic import chatbot_response

app = Flask(__name__)

# 🔹 ANALISIS PER ITEM
@app.route('/analyze', methods=['POST'])
def analyze():
    data = request.json
    result = analyze_item(data)
    return jsonify(result)

# 🔹 ALERT GLOBAL
@app.route('/alerts', methods=['POST'])
def alerts():
    items = request.json.get("items", [])
    result = generate_alerts(items)
    return jsonify({"alerts": result})

# 🔹 CHATBOT
@app.route('/chat', methods=['POST'])
def chat():
    data = request.json
    reply = chatbot_response(data.get("message", ""), data.get("items", []))
    return jsonify({"reply": reply})

@app.route('/')
def home():
    return "AI Service Ready 🚀"

if __name__ == '__main__':
    # Railway akan memberikan port secara otomatis melalui environment variable 'PORT'
    port = int(os.environ.get("PORT", 5000))
    # Host '0.0.0.0' hukumnya wajib supaya bisa diakses dari luar
    app.run(host='0.0.0.0', port=port, debug=True)