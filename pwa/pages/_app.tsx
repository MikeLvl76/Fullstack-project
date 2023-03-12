import "../styles/globals.css"
import "../styles/sidebar.css"
import "../styles/loading.css"
import "../styles/graphs.css"
import "bootstrap/dist/css/bootstrap.css"
import "bootstrap-icons/font/bootstrap-icons.css"
import '@fortawesome/fontawesome-free/css/all.min.css'
import Layout from "../components/common/Layout"
import type { AppProps } from "next/app"
import type { DehydratedState } from "react-query"

function MyApp({ Component, pageProps }: AppProps<{ dehydratedState: DehydratedState }>) {

  return <Layout dehydratedState={pageProps.dehydratedState}>
    <Component {...pageProps} />
  </Layout>
}

export default MyApp
