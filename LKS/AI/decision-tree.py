import marimo

__generated_with = "0.17.8"
app = marimo.App()


@app.cell(hide_code=True)
def _(mo):
    mo.md(r"""
    # *1.DATA COLLECTION*
    """)
    return


@app.cell
def _():
    # ============== LOAD DATASET DAN IMPORT
    import pandas as pd
    import numpy as np
    from collections import Counter
    import tkinter as tk
    import seaborn as sns
    import matplotlib.pyplot as plt

    df = pd.read_csv("Datasset LKS AI Kabupaten Malang 2025.csv")

    X = df.drop("target", axis=1)
    y = df["target"].values
    return Counter, X, df, np, pd, plt, sns, tk, y


@app.cell(hide_code=True)
def _(mo):
    mo.md(r"""
 
    """)
    return


@app.cell(hide_code=True)
def _(mo):
    mo.md(r"""
    # *2.DATA CLEANING*
    """)
    return


@app.cell
def _(df):
    # Cek nilai yang hilang
    print("Nilai yang hilang tiap kolom:")
    df.isnull().sum()
    return


@app.cell
def _(df):
    # Hapus duplikasi
    df.drop_duplicates()
    return


@app.cell
def _(df):
    # Cek tipe data
    print("\nInfo dataset setelah cleaning:")
    df.info()
    return


@app.cell(hide_code=True)
def _(mo):
    mo.md(r"""
    # *3.EDA*
    """)
    return


@app.cell
def _(df, plt, sns):
    # Hitung korelasi
    corr = df.corr()

    # Plot heatmap
    plt.figure(figsize=(12, 8))
    sns.heatmap(corr, annot=True, fmt=".2f", cmap="coolwarm", cbar=True)
    plt.title("Heatmap Korelasi Antar Fitur", fontsize=16)
    plt.show()
    return


@app.cell(hide_code=True)
def _(mo):
    mo.md(r"""
    # *5.MODELLING*
    """)
    return


@app.cell
def _(np):
    # ============== FUNGSI UNTUK MEMISAHKAN DATA TRAIN DAN TEST
    def train_test_split_manual(X, y, test_size=0.2, random_state=None):
        if random_state is not None:
            np.random.seed(random_state)
        n = len(X)
        idx = np.arange(n)
        np.random.shuffle(idx)
        test_count = int(n * test_size)
        test_idx = idx[:test_count]
        train_idx = idx[test_count:]
        return X.iloc[train_idx], X.iloc[test_idx], y[train_idx], y[test_idx]
    return (train_test_split_manual,)


@app.cell
def _(X, train_test_split_manual, y):
    # ============== SPLIT / MEMBAGI DATASET
    X_train, X_test, y_train, y_test = train_test_split_manual(X, y, test_size=0.2, random_state=42)
    return X_test, X_train, y_test, y_train


@app.cell
def _(Counter, np):
    # ============== IMPLEMENTASI DECISION TREE
    class DecisionTree:
        def __init__(self, max_depth: int = 5):
            self.max_depth = max_depth
            self.tree = None

        def gini(self, y):
            m = len(y)
            if m == 0:
                return 0
            counts = Counter(y)
            return 1 - sum((count/m)**2 for count in counts.values())

        def best_split(self, X, y):
            best_gini = 1.0
            best_idx, best_val = None, None
            m, n = X.shape

            for idx in range(n):
                values = X[:, idx]
                for val in np.unique(values):
                    left_mask = values <= val
                    right_mask = ~left_mask
                    if sum(left_mask) == 0 or sum(right_mask) == 0:
                        continue

                    gini_left = self.gini(y[left_mask])
                    gini_right = self.gini(y[right_mask])
                    gini_split = (sum(left_mask)/m) * gini_left + (sum(right_mask)/m) * gini_right

                    if gini_split < best_gini:
                        best_gini = gini_split
                        best_idx = idx
                        best_val = val
            return best_idx, best_val

        def build_tree(self, X, y, depth=0):
            if depth >= self.max_depth or len(set(y)) == 1:
                return Counter(y).most_common(1)[0][0]

            idx, val = self.best_split(X, y)
            if idx is None:
                return Counter(y).most_common(1)[0][0]

            left_mask = X[:, idx] <= val
            right_mask = ~left_mask

            return {
                "feature": idx,
                "value": val,
                "left": self.build_tree(X[left_mask], y[left_mask], depth+1),
                "right": self.build_tree(X[right_mask], y[right_mask], depth+1)
            }

        def fit(self, X, y):
            self.tree = self.build_tree(np.array(X), np.array(y))

        def predict_one(self, row, node):
            if not isinstance(node, dict):
                return node
            if row[node["feature"]] <= node["value"]:
                return self.predict_one(row, node["left"])
            else:
                return self.predict_one(row, node["right"])

        def predict(self, X):
            return [self.predict_one(row, self.tree) for row in np.array(X)]
    return (DecisionTree,)


@app.cell(hide_code=True)
def _(mo):
    mo.md(r"""
    # *6.EVALUATION*
    """)
    return


@app.cell
def _(DecisionTree, X_test, X_train, y_test, y_train):
    # ============== TRAINING DAN PREDIKSI
    clf = DecisionTree(max_depth=3)
    clf.fit(X_train, y_train)
    y_pred = clf.predict(X_test)
    correct = sum((y_pred[i] == y_test[i] for i in range(len(y_test))))
    accuracy = correct / len(y_test)
    print(f'Akurasi: {accuracy:.2f}')
    TP = sum((y_pred[i] == 1 and y_test[i] == 1 for i in range(len(y_test))))
    TN = sum((y_pred[i] == 0 and y_test[i] == 0 for i in range(len(y_test))))
    # --- hitung akurasi manual ---
    FP = sum((y_pred[i] == 1 and y_test[i] == 0 for i in range(len(y_test))))
    FN = sum((y_pred[i] == 0 and y_test[i] == 1 for i in range(len(y_test))))
    print('Confusion Matrix:')
    print(f'TP: {TP}, FP: {FP}')
    # --- confusion matrix manual ---
    print(f'FN: {FN}, TN: {TN}')
    print('Prediksi:', y_pred)
    print('Target Asli:', y_test.tolist())
    return (clf,)


@app.cell(hide_code=True)
def _(mo):
    mo.md(r"""
    # *7.REPORTING/PRESENTASION*
    """)
    return


@app.cell
def _(X, clf, pd, tk):
    def predict_input():
        # Ambil input semua kolom
        row_data = {}
        for col in X.columns:
            val = entries[col].get()
            try:
                row_data[col] = float(val)
            except ValueError:
                row_data[col] = 0.0

        df_input = pd.DataFrame([row_data])

        # Prediksi
        pred = clf.predict(df_input)[0]
        hasil_var.set(f"Prediksi target: {pred} (1=positif penyakit jantung, 0=negatif)")


    root = tk.Tk()
    root.title("Prediksi Penyakit Jantung (Decision Tree)")

    entries = {}
    for i, col in enumerate(X.columns):
        tk.Label(root, text=col).grid(row=i, column=0, sticky="w")
        e = tk.Entry(root)
        e.grid(row=i, column=1)
        entries[col] = e

    hasil_var = tk.StringVar()
    tk.Label(root, textvariable=hasil_var, fg="blue").grid(row=len(X.columns), columnspan=2)

    tk.Button(root, text="Prediksi", command=predict_input).grid(row=len(X.columns)+1, columnspan=2)

    root.mainloop()
    return


@app.cell
def _():
    import marimo as mo
    return (mo,)


if __name__ == "__main__":
    app.run()

