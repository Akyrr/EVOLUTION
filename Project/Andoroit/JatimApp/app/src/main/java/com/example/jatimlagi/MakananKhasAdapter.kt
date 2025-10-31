package com.example.jatimlagi

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView

class MakananKhasAdapter(
    private val list: List<MakananKhas>,
    private val onItemClick: (MakananKhas) -> Unit
) : RecyclerView.Adapter<MakananKhasAdapter.MakananKhasViewHolder>() {

    class MakananKhasViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
        val img: ImageView = itemView.findViewById(R.id.imgSejarah)
        val title: TextView = itemView.findViewById(R.id.tvSejarah)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): MakananKhasViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.item_sejarah, parent, false)
        return MakananKhasViewHolder(view)
    }

    override fun onBindViewHolder(holder: MakananKhasViewHolder, position: Int) {
        val item = list[position]
        holder.img.setImageResource(item.imageResId)
        holder.title.text = item.name
        holder.itemView.setOnClickListener { onItemClick(item) }
    }

    override fun getItemCount(): Int = list.size
}
