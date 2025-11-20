# /// script
# [tool.marimo.runtime]
# auto_instantiate = false
# ///

import marimo

__generated_with = "0.17.8"
app = marimo.App(width="medium")


@app.cell
def _():
    import tkinter as tk
    from tkinter import ttk
    return (tk,)


@app.cell
def _(tk):
    root = tk.Tk()
    ah = tk.Label(root, text="woi")
    ah.pack()
    root.mainloop()
    return


@app.cell
def _():
    import marimo as mo
    return


if __name__ == "__main__":
    app.run()
