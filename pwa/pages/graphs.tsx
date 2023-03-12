import React from "react";
import SideBar from "./PageComponents/sidebar";
import TabsContainer from "./Tabs/container";
import LineChart from "./Graphs/linechart";
import BarChart from "./Graphs/barchart";
import DonutChart from "./Graphs/donutchart";
import Head from "next/head";

export default function Graphs() {

    // Component in each tab
    const tabs = [
        <LineChart key={0} tabLabel="Série temporelle" width={1000} height={500} />,
        <BarChart key={1} tabLabel="Diagramme à barre" width={1000} height={500} />,
        <DonutChart key={2} tabLabel="Diagramme circulaire" width={1000} height={500} />
    ];

    return (
        <div>
            <Head>
                <title>Graphiques</title>
            </Head>
            <SideBar />
            <section className="home-section">
                <div className="home-content">
                    <span className="text">Graphiques</span>
                </div>
                <TabsContainer tabs={tabs} />
            </section>
        </div>
    )
};