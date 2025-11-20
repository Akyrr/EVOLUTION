import marimo

__generated_with = "0.17.8"
app = marimo.App()


@app.cell
def _():
    import matplotlib.pyplot as plt
    import numpy as np
    return np, plt


@app.cell
def _(np, plt):
    x = np.array([1, 2, 3, 4, 5])
    y = np.array([1, 4, 9, 16, 25])
    _y2 = np.array([1, 16, 81, 256, 625])
    plt.plot(x, y, 'r*')
    plt.plot(x, _y2, 'r--')
    # urutannya itu impor, bikin data, bikin plot, tampilin pake plot.show
    # bisa di ganti warnanya pas plot dikasih string dengan nama depan warna tsb gitu misal plot(x,y,'r') untuk menampilkan warna merah
    # kalau warnanya di tambahin -- misal 'r--' dia bakal ngebentuk garis putus putus, atau pake -o untuk garis ber bundar, ini namanya marker btw ada banyak di coumentation
    plt.show()
    return


@app.cell
def _(np, plt):
    x4= np.array(["apple","banana","pentol","tepung"])
    y4 = np.array([10,50,8,100])

    plt.bar(x4,y4)

    plt.show()
    return


@app.cell
def _(np, plt):
    def sinusGenerator(amplitudo, frekuensi, waktu, theta):
        t = np.arange(0, waktu, 0.1)
        y = amplitudo * np.sin(2 * frekuensi * t + np.deg2rad(theta))
        return (t, y)
    
    (t1, y1) = sinusGenerator(1, 1, 4, 0)
    (t2, _y2) = sinusGenerator(1, 1, 4, 50)
    (t3, y3) = sinusGenerator(1, 1, 4, 100)

    plot1 = plt.plot(t1, y1)
    plot2 = plt.plot(t2, _y2)
    plot3 = plt.plot(t3, y3)

    plt.setp(plot1, color='#00008B', linewidth=2)
    plt.setp(plot2, color='#FF0000', linewidth=2)
    plt.setp(plot3, color='#00FF15', linewidth=2)

    plt.axis([0, 4.1, -1, 1.1])

    plt.show()
    return


@app.cell
def _(np, plt):
    def sinusGenerator(amplitudo, frekuensi, waktu, theta):
        t = np.arange(0, waktu, 0.1)
        y = amplitudo * np.sin(2 * frekuensi * t + np.deg2rad(theta))
        return (t, y)
    
    (t1, y1) = sinusGenerator(1, 1, 4, 0)
    (t2, _y2) = sinusGenerator(1, 1, 4, 50)
    (t3, y3) = sinusGenerator(1, 1, 4, 100)

    plot1 = plt.plot(t1, y1)
    plot2 = plt.plot(t2, _y2)
    plot3 = plt.plot(t3, y3)

    plt.setp(plot1, color='#00008B', linewidth=2)
    plt.setp(plot2, color='#FF0000', linewidth=2)
    plt.setp(plot3, color='#00FF15', linewidth=2)

    plt.axis([0, 4.1, -1, 1.1])

    plt.show()
    return


if __name__ == "__main__":
    app.run()
