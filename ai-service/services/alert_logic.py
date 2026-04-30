def generate_alerts(items):
    alerts = []

    reject_count = sum(1 for i in items if i["status"] == "reject")
    onhold_count = sum(1 for i in items if i["status"] == "on_hold")

    if reject_count > 3:
        alerts.append(f"{reject_count} barang mengalami reject")

    if onhold_count > 5:
        alerts.append(f"{onhold_count} barang terlalu lama on_hold")

    low_stock = [i for i in items if i["quantity"] < 10]
    if len(low_stock) > 0:
        alerts.append(f"{len(low_stock)} barang stok hampir habis")

    return alerts