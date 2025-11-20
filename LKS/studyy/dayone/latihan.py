import marimo

__generated_with = "0.17.8"
app = marimo.App(width="full")


@app.cell
def _():
    import pandas as pd

    file = pd.read_csv('study.csv')
    return (file,)


@app.cell
def _(file):
    file.head()
    return


@app.cell
def _(num_columns, num_rows):
    num_rows, num_columns
    return


@app.cell
def _(file):
    file_1 = file.drop_duplicates(subset='gender', keep='first')
    file_1
    return (file_1,)


@app.cell
def _(file_1):
    apagitu = file_1.shape[0]
    apagitu
    return


@app.cell
def _(file_1):
    _bariskosong = file_1[file_1.isnull().any(axis=1)]
    _bariskosong
    return


@app.cell
def _(file_1):
    _bariskosong = file_1.columns[file_1.isnull().any()]
    _bariskosong
    return


@app.cell
def _(file_1):
    databesar = file_1.isnull().sum().idxmax()
    print(f'{databesar}')
    datahilang = file_1[databesar].isnull().sum()
    print(f'{datahilang}')
    komposisi = file_1[databesar].value_counts(dropna=False)
    komposisi
    return


@app.cell
def _(file_1):
    file_copy = file_1.copy()
    file_copy.drop(columns=['age'])
    return


@app.cell
def _(file_1):
    filter = file_1[file_1.isnull().any(axis=1)]
    print(len(filter))
    filter.head()
    return


@app.cell
def _(file_1):
    hilangkan = file_1.dropna()
    hilangkan
    return (hilangkan,)


@app.cell
def _(hilangkan):
    hilangkan.to_csv('databaru.xlsx', index=False)
    return


if __name__ == "__main__":
    app.run()
