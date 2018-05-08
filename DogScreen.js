import React from 'react';
import { Text, View, Image, FlatList, Dimensions, TouchableOpacity, } from 'react-native';
import Header from '../src/view/Header';
import DogComponent from '../src/view/DogComponent';
import DogDetailScreen from './DogDetailScreen';

export default class DogScreen extends React.Component {

  static navigationOptions = {
      header: <Header headerText="Mypetshop" />
  };

  // constructor(props) {
  //   super(props)
  //   this.state = { count: 0 }
  // }

  onPress = () => {
   navigate('DogDetailScreen', { title: 'Jane' })
  }

  render() {

    let Image_Http_URL ={ uri: 'http://www.mypetshop.com.my/image/catalog/AprilPromo_category.JPG'};
    const numColumns = 2;

    const data = [
      {id: 'a', value: 'A'},
      {id: 'b', value: 'B'},
      {id: 'c', value: 'C'},
      {id: 'd', value: 'D'},
      {id: 'e', value: 'E'},
    ];

    return (
      <View style={styles.contentStyle}>

        <Image source={Image_Http_URL} style = {styles.bannerStyle} />
        <FlatList
          data={data}
          renderItem={({item}) => (
          <View style={styles.itemContainer}>
          <TouchableOpacity
             style={styles.button}
             onPress={() => this.props.navigation.navigate('Detail')}>
             <DogComponent style={styles.item} />

           </TouchableOpacity>

          </View>
      )}
      keyExtractor={item => item.id}
      numColumns={numColumns} />

      </View>

    );
  }

}

const {height, width} = Dimensions.get('window');

const styles = {
  contentStyle: {
    flex: 1,
    backgroundColor: 'white',
  },
  bannerStyle: {
    height: 60,
    resizeMode : 'stretch',
    marginTop: 20,
    marginLeft: 10,
    marginRight: 10,
    marginBottom: 10,
  },
  list: {
    flexDirection: 'row',
    flexWrap: 'wrap'
  },
  itemContainer: {
    width: 0.5 * width,
    height: 0.75 * width,
  },
  item: {
    flex: 1,
    margin: 3,
    backgroundColor: 'lightblue',
  }
}
