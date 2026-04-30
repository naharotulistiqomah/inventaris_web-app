def safe_int(value):
    try:
        return int(value or 0)
    except (TypeError, ValueError):
        return 0


def item_name(item):
    return item.get("nama_barang") or item.get("nama") or "Tanpa nama"


def is_problem(item):
    anomaly = item.get("anomaly")
    return anomaly is not None and anomaly != "Normal"


def low_stock_items(items, limit=10):
    return [item for item in items if safe_int(item.get("jumlah")) < limit]


def status_count(items, status):
    return sum(1 for item in items if item.get("status") == status)


def status_summary(items):
    statuses = ["on_hold", "unreleased", "reject", "approved"]
    return {status: status_count(items, status) for status in statuses}


def format_names(items, limit=6):
    names = [item_name(item) for item in items]

    if not names:
        return ""

    shown = names[:limit]
    suffix = "" if len(names) <= limit else f", dan {len(names) - limit} lainnya"
    return ", ".join(shown) + suffix


def riskiest_items(items):
    def score(item):
        value = 0

        if item.get("status") == "reject":
            value += 4
        elif item.get("status") == "on_hold":
            value += 3
        elif item.get("status") == "unreleased":
            value += 1

        if is_problem(item):
            value += 4

        quantity = safe_int(item.get("jumlah"))
        if quantity < 5:
            value += 3
        elif quantity < 10:
            value += 2

        return value

    return [item for item in sorted(items, key=score, reverse=True) if score(item) > 0]


def recommendations(items):
    summary = status_summary(items)
    problem = [item for item in items if is_problem(item)]
    low_stock = low_stock_items(items)
    advice = []

    if summary["reject"] > 0:
        advice.append(f"Tindak lanjuti {summary['reject']} barang reject terlebih dahulu.")

    if problem:
        advice.append(f"Cek {len(problem)} barang yang terdeteksi anomaly: {format_names(problem, 4)}.")

    if low_stock:
        advice.append(f"Prioritaskan restock untuk: {format_names(low_stock, 4)}.")

    if summary["on_hold"] > 0:
        advice.append(f"Review {summary['on_hold']} barang on hold agar statusnya segera jelas.")

    if not advice:
        advice.append("Kondisi inventaris terlihat stabil. Tidak ada prioritas mendesak dari data saat ini.")

    return " ".join(advice)


def chatbot_response(query, items):
    query = (query or "").lower()
    items = items or []
    total = len(items)

    if "insight" in query or "analisa" in query or "analisis" in query or "ringkasan" in query:
        summary = status_summary(items)
        problem = [item for item in items if is_problem(item)]
        low_stock = low_stock_items(items)
        risk = riskiest_items(items)

        return (
            "Insight inventaris saat ini: "
            f"total {total} item, {summary['approved']} approved, {summary['reject']} reject, "
            f"{summary['on_hold']} on hold, {summary['unreleased']} unreleased. "
            f"Ada {len(problem)} barang bermasalah dan {len(low_stock)} barang stok rendah. "
            f"Prioritas utama: {format_names(risk, 5) if risk else 'tidak ada prioritas mendesak'}."
        )

    if "rekomendasi" in query or "saran" in query or "prioritas" in query or "harus dilakukan" in query:
        return "Rekomendasi AI: " + recommendations(items)

    if "paling bermasalah" in query or "risiko tertinggi" in query or "paling urgent" in query:
        risk = riskiest_items(items)

        if risk:
            return "Barang dengan risiko tertinggi: " + format_names(risk, 5) + "."

        return "Tidak ada barang dengan risiko tinggi dari data saat ini."

    if "reject" in query:
        count = status_count(items, "reject")
        names = format_names([item for item in items if item.get("status") == "reject"])
        detail = f": {names}" if names else ""
        return f"Berdasarkan data saat ini, terdapat {count} barang reject{detail}."

    if "on hold" in query or "on_hold" in query:
        count = status_count(items, "on_hold")
        names = format_names([item for item in items if item.get("status") == "on_hold"])
        detail = f": {names}" if names else ""
        return f"Berdasarkan data saat ini, terdapat {count} barang on hold{detail}."

    if "unreleased" in query:
        count = status_count(items, "unreleased")
        return f"Berdasarkan data saat ini, terdapat {count} barang unreleased."

    if "approved" in query:
        count = status_count(items, "approved")
        return f"Berdasarkan data saat ini, terdapat {count} barang approved."

    if "stok habis" in query or "hampir habis" in query or "stok rendah" in query or "stok" in query:
        low_stock = low_stock_items(items)

        if low_stock:
            return f"Ada {len(low_stock)} barang dengan stok rendah: {format_names(low_stock)}."

        return "Berdasarkan data saat ini, tidak ada stok yang hampir habis."

    if "bermasalah" in query or "masalah" in query or "anomaly" in query:
        problem = [item for item in items if is_problem(item)]

        if problem:
            return f"Berdasarkan data saat ini, terdapat {len(problem)} barang bermasalah: {format_names(problem)}."

        return "Berdasarkan data saat ini, tidak ada barang bermasalah."

    if "persentase" in query or "presentase" in query or "rasio" in query:
        if total == 0:
            return "Belum ada data barang untuk dihitung persentasenya."

        summary = status_summary(items)
        reject_rate = round(summary["reject"] / total * 100, 1)
        problem_rate = round(len([item for item in items if is_problem(item)]) / total * 100, 1)

        return f"Persentase saat ini: reject {reject_rate}%, barang bermasalah {problem_rate}% dari total {total} item."

    if "total" in query or "jumlah barang" in query:
        summary = status_summary(items)
        return (
            f"Berdasarkan data saat ini, total barang tercatat ada {total} item: "
            f"{summary['approved']} approved, {summary['reject']} reject, "
            f"{summary['on_hold']} on hold, dan {summary['unreleased']} unreleased."
        )

    return (
        "Saya bisa bantu insight inventaris. Coba tanya: ringkasan inventaris, "
        "rekomendasi AI, barang risiko tertinggi, persentase reject, "
        "barang mana bermasalah, atau stok rendah apa saja."
    )
