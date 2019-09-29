import React from 'react'
import vcCake from 'vc-cake'
import icons from './icons'

const vcvAPI = vcCake.getService('api')

export default class SocialProfileIcon extends vcvAPI.elementComponent {
  render () {
    const { title, iconPicker, socialUrl } = this.props.atts
    let customProps = {}
    let CustomTag = 'span'
    let classes = 'vce-social-profile-icon'
    const iconName = iconPicker.icon.split('vcv-ui-icon-socials-')[1]
    const svg = icons[ iconName ]
    const { url, relNofollow, targetBlank } = socialUrl

    if (url) {
      CustomTag = 'a'
      customProps = {
        'href': url,
        'title': socialUrl.title || title,
        'target': targetBlank ? '_blank' : undefined,
        'rel': relNofollow ? 'nofollow' : undefined
      }
    }

    return <CustomTag className={classes} {...customProps} dangerouslySetInnerHTML={{ __html: svg }} />
  }
}
