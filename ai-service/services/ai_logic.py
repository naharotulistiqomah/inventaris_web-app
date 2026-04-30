def analyze_item(item):
    quantity = item.get("quantity", 0)
    status = item.get("status", "")
    days = item.get("days", 0)

    # 🔴 ANOMALY
    if status == "reject" and quantity > 50:
        anomaly = "Anomali: jumlah reject tidak wajar"
    elif quantity < 0:
        anomaly = "Data tidak valid"
    elif status == "on_hold" and days > 3:
        anomaly = "Terlalu lama on_hold"
    else:
        anomaly = "Normal"

    # 🟡 PREDICTION
    if quantity < 10:
        prediction = "Stok akan habis dalam waktu dekat"
    else:
        prediction = "Stok aman"

    # 🟢 RECOMMENDATION
    if status == "reject":
        recommendation = "Periksa quality control"
    elif status == "on_hold":
        recommendation = "Segera tindaklanjuti barang"
    elif quantity < 10:
        recommendation = "Segera lakukan restock"
    else:
        recommendation = "Kondisi aman"

    return {
        "prediction": prediction,
        "anomaly": anomaly,
        "recommendation": recommendation
    }