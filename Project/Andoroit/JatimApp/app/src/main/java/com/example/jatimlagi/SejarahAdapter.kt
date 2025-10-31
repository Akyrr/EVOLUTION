package com.example.jatimlagi

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView

class SejarahAdapter(
    private val list: List<Sejarah>,
    private val onItemClick: (Sejarah) -> Unit
) : RecyclerView.Adapter<SejarahAdapter.SejarahViewHolder>() {

    class SejarahViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
        val img: ImageView = itemView.findViewById(R.id.imgSejarah)
        val title: TextView = itemView.findViewById(R.id.tvSejarah)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): SejarahViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.item_sejarah, parent, false)
        return SejarahViewHolder(view)
    }

    override fun onBindViewHolder(holder: SejarahViewHolder, position: Int) {
        val item = list[position]
        holder.img.setImageResource(item.imageResId)
        holder.title.text = item.name

        // Klik tiap item
        holder.itemView.setOnClickListener {
            onItemClick(item)
        }
    }

    override fun getItemCount(): Int = list.size
}
