import React from "react";

export default function TabBar({ tabs, activeTab, setActiveTab }: any) {
    return (
        <div className="graphs-tabs">
            {tabs.map((tab: any, index: number) => (
                <button
                    key={tab.key}
                    className={index === activeTab ? 'active' : ''}
                    onClick={() => setActiveTab(index)}
                >
                    {tab.props.tabLabel}
                </button>
            ))}
        </div>
    );
}